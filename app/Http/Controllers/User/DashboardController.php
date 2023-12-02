<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  DashboardController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user()->load('roles', 'organization','organization.archives.category');
        $CurrentRole = $user->roles->first();
        if(!$user->organization && $CurrentRole->name != 'super admin')
        {
            $user->syncRoles('regular user');
            return redirect('/home');
        }else{

            $catArchives =  $user->organization->archives()
                ->with('category')
                ->orderByRaw("FIELD(category_id, 2, 8, 9, 3, 5, 7, 1, 4, 6, 10)")
                ->get()
                ->groupBy('category.name');

            return view('dashboard.dashboard', compact('catArchives'));
        }
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
    public function destroy($id)
    {
        //
    }
}
