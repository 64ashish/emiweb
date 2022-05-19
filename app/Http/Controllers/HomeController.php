<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            $archives = Archive::where('id',1)->get()->groupBy(['category.name', function ($item) {
                return $item['place'];
            }], $preserveKeys = true);
        }


        if(auth()->user()->hasRole(['subscriber'])){
            $archives = Archive::withCount(['denmarkEmigrations'])->get()->load('category');
        }
//        $user = auth()->user();
        $user = auth()->user();



//        $catArchive = Archive::get()->groupBy('category.name');


//        $groups = Archive::where('id',1)->orWhere('id',5)->get()->groupBy(['category.name', function ($item) {
//            return $item['place'];
//        }], $preserveKeys = true);
//            return $archives;
        return view('home.dashboard', compact('user','archives'));
    }

    public function user(User $user){
//        return $user;
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
}
