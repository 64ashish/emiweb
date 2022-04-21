<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserOrganizationController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
