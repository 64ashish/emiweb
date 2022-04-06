<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Archive;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *x
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $organizations = Organization::all();
        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $organizationRequest, Organization $organization)
    {
        //
         $organization->create($organizationRequest->all());
         return redirect('/admin/organizations')->with('success', 'Organization has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        //
        return view('admin.organizations.view', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        //
//        $archives = Archive::get()->pluck('id', 'name');
        $archives = Archive::all();
        return view('admin.organizations.edit', compact('organization', 'archives'));
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
        $organization->update($organizationRequest->all());
        return redirect('/admin/organizations')->with('success', 'Organization details has been updated');
    }

    public function syncArchive(Organization $organization, Request $request)
    {

//        $user->roles()->sync($roleIds);
//        $organization->archives()->sync($request->archive_id);
//        return

        try {
            // Validate the value...
            $organization->archives()->sync($request->archive_id);
            return redirect('/admin/organizations')->with('success', 'Archives synced to organization');

        } catch (Throwable $e) {
            report($e);

            return false;
        }

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
