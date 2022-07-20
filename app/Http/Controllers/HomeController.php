<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

//use Laravel\Cashier\Subscription;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;
use Stripe\Subscription;
use function Clue\StreamFilter\append;

class HomeController extends Controller
{
    //
    public function index()
    {

        if(auth()->check())
        {
            if(auth()->user()->hasRole('super admin'))
            {
                return redirect('/admin');
            }
            if(auth()->user()->hasRole(['emiweb admin', 'emiweb staff'])){
                return redirect('/emiweb');
            }
            if(auth()->user()->hasRole(['organization admin', 'organization staff'])){
                return redirect('/dashboard');
            }

            if(auth()->user()->hasRole(['regular user'])){
//            $archives = Archive::where('id',1)->get()->groupBy(['category.name', function ($item) {
//                return $item['place'];
//            }], $preserveKeys = true);
                $archives = Archive::where('id',1)->get()->load('category');
            }


            if(auth()->user()->hasRole(['subscriber'])){
                $archives = Archive::get()->append('record_total')->load('category');
            }
//        return $archives;
//        $user = auth()->user();
            $user = auth()->user();

//        return $archives;

            return view('home.dashboard', compact('user','archives'));
        }else{
            return redirect()->to('/login');
        }


    }

    public function user(User $user){
//        return $user;
        //        authorize action

        if(auth()->user()->hasRole(['regular user']) or auth()->user()->hasRole(['subscriber'])){
            $this->authorize('update', $user);
        }

//        return $user->hasStripeId() ? "true" : "false";

//        $user->createAsStripeCustomer();

        $user = auth()->user();
//        return  $user->subscriptions()->active()->first();

        $stripe = Cashier::stripe();
        $plans = $stripe->products->all();
        $intent = $user->createSetupIntent();
        return view('home.user', compact('user', 'plans', 'intent'));
    }

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


    public function localSwitcher(Request $request)
    {
        $validate = $request->validate([
            'language' => 'required|in:sv,en|max:2',
        ]);

//        return $request->all();
        if($validate) {
            App::setLocale($request->language);
            session()->put('locale', App::getLocale());
            $url = url()->previous()."?".http_build_query(request()->except(['_token','language']));
//            return redirect($url, '302', request()->except(['_token']));
//            return redirect()->to(url()->previous(), request()->except(['_token']));

//            $inputs = request()->except(['_token']);
//            return back()->withInput($inputs);
//            return $url;
            return redirect()->to($url);
//            dd(app()->getLocale());
        }

    }
}
