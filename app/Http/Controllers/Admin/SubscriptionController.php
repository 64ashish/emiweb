<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;

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


        // get auth user
        $user = auth()->user();

//        product name
        if($request->plan === "price_1LKiPZG9lZTwpgcPGNTI9VZn")
            {
                $product = "3 Months";
            }
        if($request->plan === "price_1LKKOmG9lZTwpgcPIkYhO5EG")
        {
            $product = "Regular Subscription";
        }
//      first create stripe customer
        if($user->createOrGetStripeCustomer()){
//            check if subscription already exist or not
            if ($user->subscription($product)) {
                return redirect()->back()->with('Danger','You are already subscribed to this subscription');
            }else {
//                if it doesnt exist, process and if process is success, update privilages
                $customer = Cashier::findBillable($user->stripe_id);
                if ($customer->newSubscription($product, $request->plan)->create($request->paymentMethod)) {
                    $user->syncRoles('subscriber');
                    $user->update(['manual_expire' => null]);
                    // send email here

                }
            }
        }

        return redirect()->back()->with('Success','You are already subscribed to this subscription');
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

//        return $request->plan;

        $user = auth()->user();

        $CurrentPlan = $user->subscriptions()->active()->get()->first();

        dd($CurrentPlan->name);

//        dd($CurrentPlan->name." ".$request->plan);
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
