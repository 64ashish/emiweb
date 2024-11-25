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

//use Laravel\Cashier\Subscription;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Subscription;
use function Clue\StreamFilter\append;


class HomeController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware(function ($request, $next) {
            if(Auth::user()){
                $user_id = Auth::user()->id;
                $user = Auth::user();
                if(Auth::user()->manual_expire != '' && Auth::user()->manual_expire <= date('Y-m-d H:i:s')){
                    $user = User::find($user_id);
                    $user->manual_expire = null;
                    $user->save();
                    $user->syncRoles('regular user');
                }
                $futureExDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').'+30 days'));
                if(Auth::user()->is_mailed == 0 && Auth::user()->manual_expire != '' && Auth::user()->manual_expire <= $futureExDate){
                    $user = User::find($user_id);
                    $user->is_mailed = 1;
                    $user->save();
                    mailSend($user);
                }
                $subscriptions = $user->subscriptions()->active()->first();
                if($subscriptions != ''){
                    $today_date = date('Y-m-d H:i:s');
                    if($subscriptions->ends_at != '' && $today_date >= $subscriptions->ends_at){
                        $user->subscription($subscriptions->name)->delete();
                        $user->syncRoles('regular user');
                    }
                    else if($subscriptions->name == 'Regular Subscription'){
                        $futureDate = date('Y-m-d H:i:s', strtotime($subscriptions->created_at.'+1 year'));
                        if($today_date >= $futureDate){
                            $user->subscription($subscriptions->name)->delete();
                            $user->syncRoles('regular user');
                        }
                    }else if($subscriptions->name == '3 Months'){
                        $futureDate = date('Y-m-d H:i:s', strtotime($subscriptions->created_at.'+3 month'));
                        if($today_date >= $futureDate){
                            $user->subscription($subscriptions->name)->delete();
                            $user->syncRoles('regular user');
                        }
                    }
                }
            }
            return $next($request);
        });
    }
    //
    /**
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function index(Request $request)
    {

        if( !auth()->check() )
        {
            $ip = $request->getClientIp();

            $organization = Organization::where(function($query) use ($ip) {
                $query->where('ip_address', 'LIKE', '%'.$ip.'%')
                    ->orWhere('ip_address', 'LIKE', '%'.$ip.',%')
                    ->orWhere('ip_address', 'LIKE', '%,'.$ip.',%')
                    ->orWhere('ip_address', 'LIKE', '%,'.$ip);
            })->first();
            if(!empty($organization)){
                if($organization->expire_date >= date('Y-m-d H:i:s') || $organization->expire_date == null){
                    $organization_id = $organization->id;
                    $user = User::role('subscriber')->first();
                    if(!empty($user)){
                        $user->organization_id = $organization_id;
                        Auth::login($user);
                        Session::put('auto login', 'yes');
                    }else{
                        return redirect()->to('/login');
                    }
                }else{
                    return redirect()->to('/login')->with("error", "Your Organization has been expire");
                }
            }
            return redirect()->to('/login');
        }
        if(is_null(Auth::user()->email_verified_at))
        {
            return redirect('/email/verify');
        }

        if(auth()->user()->hasRole('super admin'))
        {
            return redirect('/admin/users');
        }
        if(auth()->user()->hasRole(['emiweb admin', 'emiweb staff'])){
            return redirect('/admin/users');
        }
        if(auth()->user()->hasRole(['organization admin', 'organization staff'])){
            return redirect('/dashboard');
        }
        // $catArchives=[];
        if(auth()->user()->hasRole(['regular user'])){

            $catArchives = Category::where('id',8)->with('archives')->has('archives')->first();

        } elseif(auth()->user()->hasRole(['subscriber', 'organizational subscriber']) and (!is_null(auth()->user()->manual_expire) and !Carbon::parse(auth()->user()->manual_expire)->greaterThanOrEqualTo(Carbon::now())) ){
            
            $catArchives = Category::where('id',8)->with('archives')->has('archives')->first();
        
        } elseif(auth()->user()->hasRole(['subscriber', 'organizational subscriber']) and (!is_null(auth()->user()->manual_expire) and Carbon::parse(auth()->user()->manual_expire)->greaterThanOrEqualTo(Carbon::now())) ){
            
            $catArchives = Category::with('archives')->has('archives')->orderByRaw('FIELD(id,2,8,9,3,5,1,4,6,10,7) ')->get();
        
        } elseif (auth()->user()->hasRole(['subscriber', 'organizational subscriber']) and is_null(auth()->user()->manual_expire) ){
//                $catArchives = Archive::get()->append('record_total')->load('category')->groupBy('category.name');
            $catArchives = Category::with('archives')->has('archives')->orderByRaw('FIELD(id,2,8,9,3,5,1,4,6,10,7) ')->get();
        }

        $user = auth()->user();

        // return $catArchives;

        // pre($catArchives); exit;
        $firstArray = array();
        $secondArray = array();
        $passangerList = array();
        foreach($catArchives as $key => $value){
            if(isset($value->name) && $value->name == 'Passenger lists'){
                foreach($value->archives as $ke => $archives){
                    if($archives->name == 'Passenger lists for Swedish ports'){
                        $firstArray[] = $archives;
                    }else{
                        $secondArray[] = $archives;
                    }
                }
                $value->archives = array();
                $passangerList = array_merge($firstArray,$secondArray);
                $value->archives = $passangerList;
            }
        }


        return view('home.dashboard', compact('user','catArchives'));


    }

    /**
     * @param User $user
     * @return Application|Factory|View
     * @throws AuthorizationException
     * @throws ApiErrorException
     */
    public function user(User $user){

        // dd(1);
        if(auth()->user()->hasRole(['regular user']) or auth()->user()->hasRole(['subscriber'])){
            $this->authorize('update', $user);
        }


        $user = auth()->user();

        $price = 0;

        if($user->subscriptions()->active()->count() > 0)
        {
            $priceName = $user->subscriptions()->active()->first()->name;

            // dd($priceName);

            if($priceName === "3 Months")
            {
                $price = 2;
            }else if($priceName === "Regular Subscription")
            {
                $price = 1;
            }
        }



        $stripe = Cashier::stripe();
        $plans = $stripe->products->all();
//        return $plans;
        $intent = $user->createSetupIntent();
        return view('home.user', compact('user', 'plans', 'intent', 'price'));
    }


    /**
     * Sync role  to user
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector|null
     * @throws AuthorizationException
     */
    public function cancelautosubc(Request $request, User $user)
    {
        $updateuser = User::where('id', $user->id)->update(['autosubsc' => date('Y-m-d H:i:s')]);

        $user = auth()->user();

        return redirect()->route('home.users.edit', ['user' => $user->id]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function updateUser(Request $request, User $user){

//        authorize action
        $this->authorize('update', $user);
//        validate inputs
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
        ]);
//        Match The Old Password
        if(!Hash::check($request->current_password, $user->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }
//        Update the new Password
        $user->update([
            'password' => Hash::make($request->password)
        ]);
//        return to dashboard
        return redirect('/home')->with('success', 'Password has been updated');
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
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     */
    public function localSwitcher(Request $request)
    {

        $validate = $request->validate([
            'language' => 'required|in:sv,en|max:2',
        ]);



        if($validate) {
            App::setLocale($request->language);
            session()->put('locale', App::getLocale());

           return  redirect('/')->with('success', 'Language has been switched');


        }

    }
}
