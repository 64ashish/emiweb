<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserOrganizationController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param Organization $organization
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Organization $organization)
    {
        $this->authorize('view', $organization);

        $getRoles = Role::all()
            ->whereNotIn('name', ['super admin','emiweb admin','emiweb staff', 'regular user', 'subscribers']);
        // prepare for drop down
        $roles = $getRoles->mapWithKeys(function ($item, $key) {
            return [$item['name'] => $item['name']];
        });

        $TheOrganization = $organization->load('users', 'archives', 'users.roles');
        return view('dashboard.organization', compact('TheOrganization','roles'));
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
     * @param OrganizationRequest $organizationRequest
     * @param Organization $organization
     * @return Response
     * @throws AuthorizationException
     */
    public function update(OrganizationRequest $organizationRequest, Organization $organization)
    {
        //
        $this->authorize('update', $organization);
        $organization->update($organizationRequest->all());
        return redirect('/dashboard')->with('success', 'Organization details updated');
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
