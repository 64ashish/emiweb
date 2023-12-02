<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;
use Stripe\InvoiceItem;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'plan' => [ 'required',
                Rule::in([config('services.subscription.3_months'),
                config('services.subscription.1_year')])
            ]
        ]);

        if ( ! $validated ) {
            return redirect()->back();

        }

        if ( $request->payment_status != 'active'){
            return redirect()->back()->with('error','Please Try Again');
        }
        
        if ( $request->stripe_id == '' || $request->stripe_price == '' || $request->customer_id == '' ){
            return redirect()->back()->with('error','Please Try Again');
        }

        $stripe_id = $request->stripe_id;
        $stripe_price = $request->stripe_price;
        $customer_id = $request->customer_id;
        $subscription_ends = date('Y-m-d H:i:s', $request->subscription_ends);

        $user = auth()->user();

        $product = $request->plan === config('services.subscription.3_months') ? "3 Months" : "Regular Subscription";
        // echo 1; exit;
        if ($user->subscription($product) ){
            return redirect()->back()->with('error','You are already subscribed to this subscription');

        }

        $customer = Cashier::findBillable($user->stripe_id);

        if($product=="Regular Subscription"){

            $already_subcription = Subscription::where('user_id',$user->id)->where('name',"Regular Subscription")->first();
            
            // $subscription = $user->newSubscription($product, $request->plan);
            // pre($subscription); exit;
            // $subscription->create($request->paymentMethod); 

            // $chargeOptions = [
            //     'description' => 'Subscription creation',
            // ];

            if($already_subcription == null){
                $sub = new Subscription();
                $sub->user_id = auth()->user()->id;
                $sub->name = $product;
                $sub->stripe_id = $stripe_id;
                $sub->stripe_price = $stripe_price;
                $sub->ends_at = $subscription_ends;
                $sub->stripe_status = 'active';
                $sub->quantity = 1;
                $sub->save();

                $userD = User::find(auth()->user()->id);
                $userD->stripe_id = $customer_id;
                $userD->save();
            }
            // else{
            //     $stripeCharge = $user->charge(
            //         250*100, $request->paymentMethod ,$chargeOptions
            //     );
            // }

            $user = auth()->user();
            $subscriptions = $user->subscriptions()->active()->first();

            if($subscriptions != ''){
                $user->syncRoles('subscriber');
                $user->update(['manual_expire' => null]);
            }

        }else{
            $already_subcription = Subscription::where('user_id',$user->id)->where('name',"3 Months")->first();

            if($already_subcription == null){
                $sub = new Subscription();
                $sub->user_id = auth()->user()->id;
                $sub->name = $product;
                $sub->stripe_id = $stripe_id;
                $sub->stripe_price = $stripe_price;
                $sub->ends_at = $subscription_ends;
                $sub->stripe_status = 'active';
                $sub->quantity = 1;
                $sub->save();

                $userD = User::find(auth()->user()->id);
                $userD->stripe_id = $customer_id;
                $userD->save();
            }

            $user = auth()->user();
            $subscriptions = $user->subscriptions()->active()->first();

            if($subscriptions != ''){
                $user->syncRoles('subscriber');
                $user->update(['manual_expire' => null]);
            }
        }

        return redirect()->back()->with('Success','You are now subscribed');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        return config('services.subscription.3_months');
        $user = auth()->user();

        $CurrentPlan = $user->subscriptions()->active()->get()->first();

        $user->subscription($CurrentPlan->name)->swapAndInvoice($request->plan);
        $user->update(['manual_expire' => null]);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
         $user = auth()->user();
         $sub_name = $user->subscriptions->first()->name;
         $user->subscription($sub_name)->cancel();

         // send email here
         return redirect()->back();

    }
}