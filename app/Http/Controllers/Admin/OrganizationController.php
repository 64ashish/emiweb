<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Models\Archive;
use App\Models\Organization;
use App\Traits\RoleBasedRedirect;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Spatie\Permission\Models\Role;

class OrganizationController extends Controller
{
    use RoleBasedRedirect;

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
     * @param OrganizationRequest $organizationRequest
     * @param Organization $organization
     * @return Response
     */
    public function store(OrganizationRequest $organizationRequest, Organization $organization)
    {
        // make organization
            $organization->create($organizationRequest->all());
        // redirect to right place
           return  $this->NowRedirectTo('/admin/organizations',
                '/emiweb/organizations',
            __('Organization has been added') 
            );

    }

    /**
     * Display the specified resource.
     *
     * @param Organization $organization
     * @return Response
     */
    public function show(Organization $organization)
    {

//        return $organization->load( 'users.roles');
        // get all roles
        $getRoles = Role::all()
            ->whereNotIn('name', ['super admin','emiweb admin','emiweb staff',  'subscriber']);
//        // prepare for drop down
        $roles = $getRoles->mapWithKeys(function ($item, $key) {
            return [$item['name'] => $item['name']];
        });
//
        $TheOrganization = $organization->load('archives', 'users.roles');
//        return $TheOrganization->name;
//
        return view('admin.organizations.view', compact('TheOrganization','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organization $organization
     * @return Response
     */
    public function edit(Organization $organization)
    {
        //
//        $archives = Archive::get()->pluck('id', 'name');
        $getRoles = Role::all()
            ->whereNotIn('name', ['super admin','emiweb admin','emiweb staff',  'subscriber']);
        // prepare for drop down
        $roles = $getRoles->mapWithKeys(function ($item, $key) {
            return [$item['name'] => $item['name']];
        });
        $archives = Archive::all();
        $TheOrganization = $organization->load('archives', 'users.roles');
        return view('admin.organizations.edit', compact('TheOrganization', 'archives', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrganizationRequest $organizationRequest
     * @param Organization $organization
     * @return Response
     */
    public function update(OrganizationRequest $organizationRequest, Organization $organization)
    {
        //
        $organization->update($organizationRequest->all());

        return  $this->NowRedirectTo('/admin/organizations',
            '/emiweb/organizations',
            __('Organization details has been updated') 
        );


    }

    /**
     * @param Organization $organization
     * @param Request $request
     * @return false|Application|RedirectResponse|Redirector|null
     */
    public function syncArchive(Organization $organization, Request $request)
    {



        try {
            // Validate the value...
            $organization->archives()->sync($request->archive_id);
//            return redirect('/admin/organizations')->with('success', 'Archives synced to organization');

            return  $this->NowRedirectTo('/admin/organizations',
                '/emiweb/organizations',
                __('Archives synced to organization') 
            );


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
