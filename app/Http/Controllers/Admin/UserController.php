<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Traits\RoleBasedRedirect;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use RoleBasedRedirect;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with(['roles.permissions','organization'])->get();
//        $users = User::all();
        return view('admin.users.index', compact('users'));
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
    public function edit(User $user)
    {
        //
        $roles = Role::whereNotIn('name', ['super admin','organization admin', 'organization staff'])->get();
        return view('admin.users.edit', compact('user', 'roles'));

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
     * Search for the user for association with organization
     * @param Request $request
     * @param Organization $organization
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'email' => 'email'
        ]);

        if($validated) {
            $users = User::where('status', '1')
                ->where('email', 'like', $request->email)
                ->get();

            return view('admin.organizations.user_search', compact('users', 'organization'));
        }


    }

    /**
     * sync user with organization
     * @param Request $request
     * @param Organization $organization
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function syncWithOrganization(Request $request, Organization $organization, User $user)
    {

//       if the user is being disconnected from a member
        if($request->disconnect == true)
        {
            $user->update(['organization_id' => null]);

            $user->syncRoles('regular user');

            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User disassociated with the Organization!'
            );



        }else{
//            check if the user is already associated or not

            if($user->organization_id != null)
            {
                return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                    '/emiweb/organizations/'.$organization->id,
                    'User is already associated  with another Organization!'
                );
            }
//            assign to the organization
            $user->update(['organization_id' => $organization->id]);
//            give user the role
            $user->syncRoles('organization staff');
//        redirect appropriately
            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User associated with the Organization!'
            );

        }

    }

    public function syncRole(Request $request,User $user){

//        return $request->all();

//         dont update superadmin
            $CurrentRole = $user->roles->first();
            if(($CurrentRole != null && $CurrentRole->name === "super admin") or ($request->name === "super admin"))
            {
                return  $this->NowRedirectTo('/admin/users/',
                    '/emiweb/users/',
                    'Are you really trying to update super admin?'
                );

            }else{
                // redirect to user list with you cant do that message
                $user->syncRoles([$request->name]);

                return  $this->NowRedirectTo('/admin/users/',
                    '/emiweb/users/',
                    'User updated'
                );


            }
        //
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
