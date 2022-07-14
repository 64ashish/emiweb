<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

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
        //
//        dd($request->all());
        // get auth user
        $user = auth()->user();

//        product name
        if($request->plan === "price_1LKiPZG9lZTwpgcPGNTI9VZn")
            {
                $product = "prod_M2o1kJWe69bLhW";
            }
        if($request->plan === "price_1LKKOmG9lZTwpgcPIkYhO5EG")
        {
            $product = "prod_M2PDzlnwXjwU6b";
        }
        $stripefy = $user->createOrGetStripeCustomer();

//        return $user->subscriptions;
        // check if user already has active subscription to this plan
        if ($user->subscription($product)) {

            return redirect()->back()->with('Alert','You are already subscribed to this subscription');

        }else {
            if(auth()->user()->newSubscription($product, $request->plan)->create($request->paymentMethod)){
                $user->syncRoles('subscriber');
            }

        }

        return redirect()->back();




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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        $user = auth()->user();
         $sub_name = $user->subscriptions->first()->name;
         $user->subscription($sub_name)->cancel();
         return redirect()->back();

    }
}
