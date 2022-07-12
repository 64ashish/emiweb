<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;
use Stripe\Subscription;
use function Clue\StreamFilter\append;

class HomeController extends Controller
{
    //
    public function index()
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
    }

    public function user(User $user){
//        return $user;
        //        authorize action

        if(auth()->user()->hasRole(['regular user']) or auth()->user()->hasRole(['subscriber'])){
            $this->authorize('update', $user);
        }

        return \Laravel\Cashier\Subscription::

        return view('home.user', compact('user'));
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


    public function localSwitcher(Request $request)
    {
        $validate = $request->validate([
            'language' => 'required|in:sv,en|max:2',
        ]);

        if($validate) {
            App::setLocale($request->language);
            session()->put('locale', App::getLocale());
            return back();
//            dd(app()->getLocale());
        }

    }
}
