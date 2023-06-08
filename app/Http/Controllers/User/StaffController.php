<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * @param Organization $organization
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Organization $organization, User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::whereNotIn('name', ['super admin','emiweb admin', 'emiweb staff', 'subscriber', 'regular user'])->get();
        return view('dashboard.user_edit', compact('user', 'roles', 'organization'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {

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
        return redirect('/dashboard')->with('success', 'Password has been updated');
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

        $this->authorize('syncWithOrganization', $user);
        $request->validate([
            'disconnect' => 'required'
        ]);
//       if the user is being disconnected from a member
        if($request->disconnect === "1")
        {
            $user->update(['organization_id' => null]);
            $user->syncRoles('regular user');
            return redirect('/dashboard')->with('success', 'Role has been disassociated from organization');
        }
        return abort(403, 'You dont have permission to do that');

    }

    /**
     * @param Request $request
     * @param Organization $organization
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|never
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function syncRole(Request $request, Organization $organization, User $user)
    {

        $this->authorize('syncRole', $user);

        $request->validate([
            'name' => 'required'
        ]);

        if($request->name === 'organization admin' or $request->name === 'organization staff')
        {
            $user->syncRoles([$request->name]);
            return redirect('/dashboard')->with('success', 'Role has been synced with user');
        }
        return abort(403, 'You dont have permission to do that');

    }

    /**
     * @param Organization $organization
     * @return Organization
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function associations(Organization $organization)
    {
        $this->authorize('viewAssociations', $organization);

        $associations = $organization->association;
        return view('dashboard.user_association', compact('associations'));
    }

    /**
     * @param Request $request
     * @param Organization $organization
     * @param User $user
     * @return Application|RedirectResponse|Redirector|never
     * @throws AuthorizationException
     */
    public function approveAssociation(Request $request, Organization $organization, User $user)
    {
//        check for empty stuff
        if(is_null($user->association))
        {
            return abort(403, 'not enough information');
        }
//        check if this is allowed or not
        $this->authorize('approveAssociation', $user->association->organization);
//        validate the inputs, if false, go back
        $request->validate([
            'decision' => 'required'
        ]);
//        if approved, associate with organization, grant staff permission and remove association request
        if($request->decision === "1"){
//            associate with ogranization
            $user->update(['organization_id' => $organization->id]);
//            give user the role
            $user->syncRoles('organization staff');
//            delete the association request
            $user->association->delete();
//            redirect with message
            return redirect('/dashboard')->with('success', 'User is now associated as organization staff');
        }
//        if rejected, remove association request
        if($request->decision === "0"){
//            association request removed
            $user->association->delete();
//            redirect with message
            return redirect('/dashboard')->with('success', 'Association request rejected');
        }
        return abort(403, 'it didnt work');
    }
}
