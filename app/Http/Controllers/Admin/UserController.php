<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Traits\RoleBasedRedirect;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Role;
use Stripe\Stripe;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
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

    use RoleBasedRedirect;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['roles.permissions','organization','latestLogin'])->orderBy('id', 'DESC')->paginate(50);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
        //        return $user;
        //        return $user->subscriptions()->active()->get()->count();
        //$roles = Role::whereNotIn('name', ['super admin','organization admin', 'organization staff'])->get();
        $roles = Role::whereNotIn('name', ['super admin'])->get();


       /* $user = Auth::user();

        if($user->hasRole('super admin')){
            dd('admin');
        }*/
        return view('admin.users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        if(isset($request->is_password_update) && $request->is_password_update == 1){
            # Validation
            $request->validate([
                'current_password' => 'required',
                'password' => 'required',
                'address' => 'required',
                'postcode' => 'required',
                'ip_address'=>'nullable|ip'
            ]);

            #Match The Old Password
            if(!Hash::check($request->current_password, $user->password)){
                return back()->with("error", "Old Password Doesn't match!");
            }

            #Update the new Password
            $user->update([
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'postcode' => $request->postcode,
            ]);


            // return redirect()->route('admin.users.edit', $user->id);
            return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
                '/emiweb/users/'.$user->id.'/edit/',
                'Details is updated'
            );
        }else{
            # Validation
            $request->validate([
                'address' => 'required',
                'postcode' => 'required',
            ]);
            User::where('id', $user->id)->update([
                'address' => $request->address,
                'postcode' => $request->postcode,
            ]);

            // return redirect()->route('admin.users.edit', $user->id);
            return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
                '/emiweb/users/'.$user->id.'/edit/',
                'Details is updated'
            );
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function searchForAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required'
        ]);

        if($validated) {
            $users = User::where('email', 'like', $request->email)->orWhere('name','LIKE', '%'.$request->email.'%')->paginate(50);

            return view('admin.users.index', compact('users'));
        }
    }

    /**
     * Search for the user for association with organization
     * @param Request $request
     * @param Organization $organization
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'email' => 'email'
        ]);

        if($validated) {
            $users = User::where('email', 'like', $request->email)
                ->get();

            return view('admin.organizations.user_search', compact('users', 'organization'));
        }


    }

    /**
     * sync user with organization
     * @param Request $request
     * @param Organization $organization
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function syncWithOrganization(Request $request, Organization $organization, User $user)
    {
        $this->authorize('syncWithOrganization', $user);
        if($request->disconnect == true)
        {
            $user->update(['organization_id' => null]);

            $user->syncRoles('regular user');
            $user->update(['manual_expire' => null]);

            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User disassociated with the Organization!'
            );



        }else{
            if($user->organization_id != null)
            {
                return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                    '/emiweb/organizations/'.$organization->id,
                    'User is already associated  with another Organization!'
                );
            }
            $user->update(['organization_id' => $organization->id]);
            $user->syncRoles('regular user');
            $user->update(['manual_expire' => Carbon::now()->addYear()]);
            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User associated with the Organization!'
            );

        }

    }

    /**
     * Sync role  to user
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector|null
     * @throws AuthorizationException
     */
    public function syncRole(Request $request, User $user)
    {
        $this->authorize('syncRole', $user);

        //  dont update superadmin
        $CurrentRole = $user->roles->first();
        if(($CurrentRole != null && $CurrentRole->name === "super admin") or ($request->name === "super admin"))
        {
            return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
                '/emiweb/users/'.$user->id.'/edit/',
                'Are you really trying to update super admin?'
            );

        }else{

            //  return Carbon::now()->addYear();
            // redirect to user list with you cant do that message
            if($request->name == "subscriber" or $request->name == "organizational subscriber")
            {
                if($request->expiry_date != ''){
                    $manual_expire = $request->expiry_date;
                }else{
                    $manual_expire = Carbon::now()->addYear();
                }
                $user->update(['manual_expire' => $manual_expire,'is_mailed' => 0]);
                $user->subscriptions()->active()->update(['ends_at' => $manual_expire]);

                $subscriptions = $user->subscriptions->first();
                if(!empty($subscriptions)){
                    $sub_id = $subscriptions->stripe_id;

                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    try{
                        $stripe->subscriptions->update($sub_id, ['cancel_at' => strtotime($manual_expire)]);
                        $subData = $stripe->subscriptions->retrieve(
                            $sub_id,
                            []
                        );
                    }catch (\Exception $e) {
                        $api_error = $e->getMessage();
                    }
                }
            }else
            {
                $user->update(['manual_expire' => null]);
                $user->subscriptions()->active()->update(['ends_at' => null]);
            }
            $user->syncRoles([$request->name]);
            
            return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
                '/emiweb/users/'.$user->id.'/edit/',
                'User updated'
            );
        }
    }

    /**
     * List all subscribers
     * @return Application|Factory|View
     */
    public function subscribers()
    {
        $manualSubscriptions = User::role('subscriber')
            ->whereNotNull('manual_expire')
            ->where('manual_expire', '>=', Carbon::now())
            ->get();
        //        return $manualSubscriptions;
        $subscriptions =  Subscription::query()->with('user')->active()->get();
        //        return $subscriptions;
        return view('admin.users.subscriptions', compact('subscriptions', 'manualSubscriptions'));
    }

    /**
     * Cancel subscription for a user
     * @param User $user
     * @return RedirectResponse
     */
    public function subscriptionCancel(User $user)
    {
        $sub_name = $user->subscriptions->first()->name;
        $user->subscription($sub_name)->cancel();
        return redirect()->back()->with('Success', 'Subscription is now cancelled');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payment(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $price_id = $request->plan_id;
            $duration = $request->duration;

            if ($duration == 1) {
                $endDate = Carbon::now()->addMonths(12);
            } else {
                $endDate = Carbon::now()->addMonths(3);
            }

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            try{
                $customer = \Stripe\Customer::create(array(
                    "name" => $request->cardHolderName,
                    "email" => Auth::user()->email
                ));
            }catch(\Exception $e){
                $api_error = $e->getMessage();
            }
            
            if(empty($api_error) && $customer){
                try{
                    if ($request->coupon_name != '') {
                        $subscriptionData = [
                            'customer' => $customer->id,
                            'items' => [
                                [
                                    'price' => $price_id
                                ],
                            ],
                            'payment_behavior' => 'default_incomplete',
                            'coupon' => $request->coupon_name,
                            'expand' => ['latest_invoice.payment_intent'],
                            'proration_behavior' => 'none'
                        ];
                    } else {
                        $subscriptionData = [
                            'customer' => $customer->id,
                            'items' => [
                                ['price' => $price_id],
                            ],
                            'payment_behavior' => 'default_incomplete',
                            'expand' => ['latest_invoice.payment_intent'],
                            'proration_behavior' => 'none'
                        ];
                    }
                    
                    // Conditionally add 'cancel_at' based on the user's auto subscription setting
                    if (Auth::user()->is_auto_sub != 1) {
                        $subscriptionData['cancel_at'] = $endDate->timestamp;
                    }
                    
                    $subscription = $stripe->subscriptions->create($subscriptionData);
                }catch(\Exception $e){
                    $api_error = $e->getMessage();
                }

                if(empty($api_error) && $subscription){
                    $output = [
                        'subscriptionId' => $subscription->id,
                        'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
                        'customerId' => $customer->id,
                    ];
                    return response()->json(['status' => 'true', 'output' => $output], 200);
                }else{
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }else{
                return response()->json(['error' => $e->getMessage()], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function savepayment(Request $request) {
        $payment_intent = isset($request->payment_intent)?$request->payment_intent:''; 
        $subscription_id = isset($request->subscription_id)?$request->subscription_id:''; 
        $customer_id = isset($request->customer_id)?$request->customer_id:''; 
        $plan_id = isset($request->plan_id)?$request->plan_id:'';
        $payment_method = isset($request->payment_method)?$request->payment_method:'';

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        try{
            $customer = $stripe->customers->retrieve(
                $customer_id,
                []
            );
        }catch (\Exception $e) {
            $api_error = $e->getMessage();
        }
        if(!empty($payment_intent) && $payment_intent['status'] == 'succeeded'){
            try{
                $subData = $stripe->subscriptions->retrieve(
                    $subscription_id,
                    []
                );
            }catch (\Exception $e) {
                $api_error = $e->getMessage();
            }
        }

        if(empty($api_error)){
            return response()->json(['status' => 'true', 'subData' => $subData, 'payment_method' => $payment_method], 200);
        }else{
            return response()->json(['status' => 'false','error' => $e->getMessage()], 500);
        }
    }

    public function checkCoupon(Request $request)
    {
        $couponCode = $request->couponCode;
        $stripeSecretKey = env('STRIPE_SECRET');

        $url = "https://api.stripe.com/v1/coupons/{$couponCode}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $stripeSecretKey,
            ])->get($url);

            $responseData = $response->json();
            if ($response->status() === 200) {
                // pre($responseData); exit;
                if(isset($responseData['duration_in_months']) && $responseData['duration_in_months'] != ''){
                    $date1 = date('Y-m-d H:i:s', $responseData['created']);
                    $futureDate = date('Y-m-d H:i:s', strtotime($date1.' + '.$responseData['duration_in_months'].' month'));
                    $today_date = date('Y-m-d H:i:s');
                    if(isset($responseData['created']) && $today_date >= $futureDate){
                        return response()->json(['status' => 'false','message' => 'Coupon Expired.']);
                    }
                }
                if(isset($responseData['redeem_by']) && $responseData['redeem_by'] != ''){
                    $date2 = date('Y-m-d H:i:s', $responseData['created']);
                    $today_date = date('Y-m-d H:i:s');
                    if(isset($responseData['created']) && $today_date >= $date2){
                        return response()->json(['status' => 'false','message' => 'Coupon Expired.']);
                    }
                }
                if(isset($responseData['max_redemptions']) && $responseData['times_redeemed'] && $responseData['times_redeemed'] <= $responseData['max_redemptions']){
                    return response()->json(['status' => 'false','message' => 'Coupon is Already used']);
                }
                return response()->json(['status' => 'true','message' => 'Coupon exists.']);
            } else {
                return response()->json(['status' => 'false','message' => 'Coupon does not exist.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function expirePlan(Request $request, User $user){
        $validated = $request->validate([
            'expiry_date' => 'required'
        ]);

        $user_id = $user->id;
        if($user->manual_expire != ''){
            $user = User::find($user_id);
            $user->manual_expire = date('Y-m-d H:i:s', $request->expiry_date);
            $user->save();
        }
        if(count($user->subscriptions()->active()->get()) > 0){
            $subscriptions = $user->subscriptions()->active()->first();
            $user->subscriptions()->active()->update([
                'ends_at' => date('Y-m-d H:i:s', strtotime($request->expiry_date)),
            ]);
        }
        return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
            '/emiweb/users/'.$user->id.'/edit/',
            'Expiry Date Changed'
        );
    }

    public function autopayment(Request $request, User $user){
        $user = Auth::user();
        $subscriptions = $user->subscriptions->first();
        if(!empty($subscriptions)){
            $sub_id = $subscriptions->stripe_id;

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            if($request->is_auto_sub == 1){
                try{
                    $stripe->subscriptions->update($sub_id, ['cancel_at_period_end' => false]);
                    $subData = $stripe->subscriptions->retrieve(
                        $sub_id,
                        []
                    );

                    $date = "";
                }catch (\Exception $e) {
                    $api_error = $e->getMessage();
                }
            }else{
                try{
                    $stripe->subscriptions->update($sub_id, ['cancel_at_period_end' => true]);
                    $subData = $stripe->subscriptions->retrieve(
                        $sub_id,
                        []
                    );

                    $date = date('Y-m-d', $subData->canceled_at);
                }catch (\Exception $e) {
                    $api_error = $e->getMessage();
                }
            }   

            if(empty($api_error)){
                $update = User::find($user->id);
                $update->is_auto_sub = $request->is_auto_sub;
                $update->save();
                return response()->json(['status' => 'true', 'is_auto_sub' => $request->is_auto_sub, 'date' => $date], 200);
            }else{
                return response()->json(['status' => 'false','error' => $e->getMessage()], 500);
            }
        }else{
            return response()->json(['status' => 'false','error' => 'Missing Subscription Data'], 500);
        }
    }
}
