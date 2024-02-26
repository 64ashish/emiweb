<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use App\Models\User;
use App\Models\Organization;
use Carbon\Carbon;
use http\Url;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

// use Laravel\Cashier\Subscription;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Subscription;
use function Clue\StreamFilter\append;
use App\Models\News;
use App\Models\NewsLog;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $user_id = Auth::user()->id;
                $user = Auth::user();
                if (Auth::user()->manual_expire != '' && Auth::user()->manual_expire <= date('Y-m-d H:i:s')) {
                    $user = User::find($user_id);
                    $user->manual_expire = null;
                    $user->save();
                    $user->syncRoles('regular user');
                }
                $futureExDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . '+30 days'));
                if (Auth::user()->is_mailed == 0 && Auth::user()->manual_expire != '' && Auth::user()->manual_expire <= $futureExDate) {
                    $user = User::find($user_id);
                    $user->is_mailed = 1;
                    $user->save();
                    mailSend($user);
                }

                // Get the ID of the latest news
                $latestNewsId = News::latest()->first()->id;

                // Get the ID of the authenticated user
                $userId = Auth::id();

                // Check if there is a user and if there exists a NewsLog entry for the latest news and the authenticated user
                if ($user && NewsLog::where('user_id', $userId)->where('news_id', $latestNewsId)->exists()) {
                    // Set the variable to true if the user has seen the latest news
                    $userHasSeenLatestNews = true;
                } else {
                    // Set the variable to false if the user has not seen the latest news
                    $userHasSeenLatestNews = false;
                }

                // Store the user's latest news viewing status in the session
                Session::put('user_has_seen_latest_news', $userHasSeenLatestNews);

                $subscriptions = $user->subscriptions()->active()->first();

                if ($subscriptions != '') {
                    $today_date = date('Y-m-d H:i:s');
                    if ($subscriptions->ends_at != '' && $today_date >= $subscriptions->ends_at) {
                        $user->subscription($subscriptions->name)->delete();
                        $user->syncRoles('regular user');
                    } else if ($subscriptions->name == 'Regular Subscription') {
                        $futureDate = date('Y-m-d H:i:s', strtotime($subscriptions->created_at . '+1 year'));
                        if ($today_date >= $futureDate) {
                            $user->subscription($subscriptions->name)->delete();
                            $user->syncRoles('regular user');
                        }
                    } else if ($subscriptions->name == '3 Months') {
                        $futureDate = date('Y-m-d H:i:s', strtotime($subscriptions->created_at . '+3 month'));
                        if ($today_date >= $futureDate) {
                            $user->subscription($subscriptions->name)->delete();
                            $user->syncRoles('regular user');
                        }
                    }
                }
            }
            return $next($request);
        });
    }

    /**
     * Display the user's dashboard.
     *
     * This function handles the logic for displaying the user's dashboard.
     * It checks if the user is authenticated and redirects them if necessary.
     * It also handles redirection based on user roles and subscription status.
     * Additionally, it fetches category archives based on user roles and subscription.
     * Finally, it manipulates the category archives array before passing it to the view.
     *
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function index(Request $request)
    {

        // Handle redirection for unauthenticated users
        if (!auth()->check()) {
            // Retrieve organization based on IP address
            $organization = Organization::where('ip_address', 'LIKE', '%' . $request->getClientIp() . ',%')->orWhere('ip_address', 'LIKE', '%'.$request->getClientIp())->first();
            if (!empty($organization)) {
                if ($organization->expire_date >= date('Y-m-d H:i:s') || $organization->expire_date == null) {
                    // Automatically log in the first user with the 'subscriber' role
                    $organization_id = $organization->id;
                    $user = User::role('subscriber')->whereNotNull('email_verified_at')->first();
                    if (!empty($user)) {
                        Auth::login($user);
                        Session::put('auto login', 'yes');
                    } else {
                        // If no user with 'subscriber' role is found, redirect to login page
                        $request->session()->put('passby', true);
                        return redirect()->to('/login');
                    }
                } else {
                    // If organization's subscription has expired, redirect to login page with an error message
                    return redirect()->to('/login')->with("error", "Your Organization has expired");

                }
            }
            // If no organization is found, redirect to login page
            $request->session()->put('passby', true);
            return redirect()->to('/login');
        }

        // Redirect if email is not verified
        if (is_null(Auth::user()->email_verified_at)) {
            return redirect('/email/verify');
        }

        // Redirect based on user roles
        if ($request->session()->get('passby')) {
            $request->session()->put('passby', false);
            // Redirect to admin panel if user has 'super admin', 'emiweb admin', or 'emiweb staff' role
            if (auth()->user()->hasRole(['super admin', 'emiweb admin', 'emiweb staff'])) {
                return redirect()->to('/admin/users');
            }
        }

        // Redirect to organization dashboard if user has 'organization admin' or 'organization staff' role
        if (auth()->user()->hasRole(['organization admin', 'organization staff'])) {
            return redirect('/dashboard');
        }

        // Fetch category archives based on user roles and subscription
        $catArchives = null;
        if (auth()->user()->hasRole(['regular user'])) {
            // Fetch category archives for regular users
            $catArchives = Category::where('id', 8)->with('archives')->has('archives')->first();
        } elseif (auth()->user()->hasRole(['subscriber', 'organizational subscriber']) and (!is_null(auth()->user()->manual_expire) and !Carbon::parse(auth()->user()->manual_expire)->greaterThanOrEqualTo(Carbon::now()))) {
            // Fetch category archives for subscribers with active manual expiration
            $catArchives = Category::where('id', 8)->with('archives')->has('archives')->first();
        } elseif (auth()->user()->hasRole(['subscriber', 'organizational subscriber']) and (!is_null(auth()->user()->manual_expire) and Carbon::parse(auth()->user()->manual_expire)->greaterThanOrEqualTo(Carbon::now()))) {
            // Fetch category archives for subscribers with future manual expiration
            $catArchives = Category::with('archives')->has('archives')->orderByRaw('FIELD(id,2,8,9,3,5,1,4,6,10,7) ')->get();
        } elseif (auth()->user()->hasRole(['subscriber', 'super admin', 'emiweb admin', 'emiweb staff', 'organizational subscriber']) and is_null(auth()->user()->manual_expire)) {
            // Fetch category archives for subscribers with no manual expiration
            $catArchives = Category::with('archives')->has('archives')->orderByRaw('FIELD(id,2,8,9,3,5,1,4,6,10,7) ')->get();
        }

        // Get authenticated user
        $user = auth()->user();

        // Manipulate the category archives array
        $firstArray = array();
        $secondArray = array();
        $passangerList = array();
        foreach ($catArchives as $key => $value) {
            if (isset($value->name) && $value->name == 'Passenger lists') {
                foreach ($value->archives as $ke => $archives) {
                    if ($archives->name == 'Passenger lists for Swedish ports') {
                        $firstArray[] = $archives;
                    } else {
                        $secondArray[] = $archives;
                    }
                }
                $value->archives = array();
                $passangerList = array_merge($firstArray, $secondArray);
                $value->archives = $passangerList;
            }
        }

        // Pass user and category archives to the dashboard view
        return view('home.dashboard', compact('user', 'catArchives'));
    }


    /**
     * Display the specified user.
     *
     * @param User $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     * @throws ApiErrorException
     */
    public function user(User $user)
    {

        // Authorize action
        if (auth()->user()->hasRole(['regular user']) or auth()->user()->hasRole(['subscriber'])) {
            $this->authorize('update', $user);
        }

        $user = auth()->user();

        $price = 0;

        // Calculate price based on subscription
        if ($user->subscriptions()->active()->count() > 0) {
            $priceName = $user->subscriptions()->active()->first()->name;

            if ($priceName === "3 Months") {
                $price = 2;
            } else if ($priceName === "Regular Subscription") {
                $price = 1;
            }
        }

      
         $stripe = Cashier::stripe();
         $plans = $stripe->products->all();

        // Retrieve user details from the userDetails relation
        $userDetails = $user->userDetails;

        // Use null-coalescing operator to avoid errors
        $address = $userDetails->address ?? null;
        $phone = $userDetails->phone ?? null;
        $country = $userDetails->country ?? null;
        $location = $userDetails->location ?? null;
        $city = $userDetails->city ?? null;
        $postcode = $userDetails->postcode ?? null;
  

        $intent = $user->createSetupIntent();
        return view('home.user', compact(
            'user',  
            'plans',  
            'intent',
            'price',
            'address',
            'phone',
            'country',
            'location',
            'city',
            'postcode'
        ));
    }

    /**
     * Cancel auto subscription for a user.
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector|null
     */
    public function cancelautosubc(Request $request, User $user)
    {
        $updateuser = User::where('id', $user->id)->update(['autosubsc' => date('Y-m-d H:i:s')]);

        $user = auth()->user();

        return redirect()->route('home.users.edit', ['user' => $user->id]);
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function updateUser(Request $request, User $user)
    {

        // Authorize action
        $this->authorize('update', $user);

        // Update user details if provided
        if ($request->filled('address') || $request->filled('phone') || $request->filled('country') || $request->filled('location') || $request->filled('city') ||  $request->filled('postcode')) {
          
            $userDetailsData = [
                'address' => $request->address,
                'phone' => $request->phone,
                'country' => $request->country,
                'location' => $request->location,
                'city' => $request->city,
                'notes' => $request->notes,
                'postcode' => $request->postcode,
            ];
            
            // Update user details
            if ($user->userDetails) {
                // Details already exists, update
                $user->userDetails->update($userDetailsData);
            } else {
                //If userDetails does not exist, create new details
                $user->userDetails()->create($userDetailsData);
            }
       
            $message = __('User details have been updated');
        } else {

            // Validate inputs
            $request->validate([
                'current_password' => 'required',
                'password' => 'required',
            ]);

            // Match the old password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with("error", __('Old Password Doesn\'t match!'));
            }

            // Update the new password
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            $message = __('Password has been updated');
        }

        // Return to dashboard with appropriate message
        return redirect('home/users/'. $user->id)->with('success', $message);
    }

    //    public function endSubscription(User $user){
//
//        $this->authorize('update', $user);
//        $sub_name = $user->subscriptions->first()->name;
//        $user->subscription($sub_name)->cancel();
//        return redirect()->back()->with('Success', 'Subscription is now cancelled');
//
//    }

    /**
     * Switch the application locale.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     */
    public function localSwitcher(Request $request)
    {

        $validate = $request->validate([
            'language' => 'required|in:sv,en|max:2',
        ]);

        if ($validate) {
            App::setLocale($request->language);
            session()->put('locale', App::getLocale());

            return  redirect('/')->with('success', 'Language has been switched');
        }
    }
}

