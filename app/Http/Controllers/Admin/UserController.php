<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Traits\RoleBasedRedirect;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\Fortify;
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
        $users = User::with(['roles.permissions','organization'])->orderBy('id', 'DESC')->paginate(50);
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
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
        //        return $user;
        //        return $user->subscriptions()->active()->get()->count();
        //$roles = Role::whereNotIn('name', ['super admin','organization admin', 'organization staff'])->get();
        $roles = Role::whereNotIn('name', ['super admin'])->get();


       /* $user = Auth::user();

        if($user->hasRole('super admin')){
            dd('admin');
        }*/
        return view('admin.users.edit', compact('user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        # Validation
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
            'ip_address'=>'nullable|ip'
        ]);

        #Match The Old Password
        if(!Hash::check($request->current_password, $user->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        $user->update([
            'password' => Hash::make($request->password)
        ]);


        // return redirect()->route('admin.users.edit', $user->id);
        return  $this->NowRedirectTo('/admin/users/'.$user->id.'/edit/',
            '/emiweb/users/'.$user->id.'/edit/',
            'password is updated'
        );

    }

    /**
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function searchForAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required'
        ]);

        if($validated) {
            $users = User::where('email', 'like', $request->email)->orWhere('name','LIKE', '%'.$request->email.'%')->paginate(50);

            return view('admin.users.index', compact('users'));
        }
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
            $users = User::where('email', 'like', $request->email)
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
        $this->authorize('syncWithOrganization', $user);
        if($request->disconnect == true)
        {
            $user->update(['organization_id' => null]);

            $user->syncRoles('regular user');
            $user->update(['manual_expire' => null]);

            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User disassociated with the Organization!'
            );



        }else{
            if($user->organization_id != null)
            {
                return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                    '/emiweb/organizations/'.$organization->id,
                    'User is already associated  with another Organization!'
                );
            }
            $user->update(['organization_id' => $organization->id]);
            $user->syncRoles('regular user');
            $user->update(['manual_expire' => Carbon::now()->addYear()]);
            return  $this->NowRedirectTo('/admin/organizations/'.$organization->id,
                '/emiweb/organizations/'.$organization->id,
                'User associated with the Organization!'
            );

        }

    }

    /**
     * Sync role  to user
     * @param Request $request
     * @param User $user
     * @return Application|RedirectResponse|Redirector|null
     * @throws AuthorizationException
     */
    public function syncRole(Request $request, User $user)
    {

        $this->authorize('syncRole', $user);

        //  dont update superadmin
        $CurrentRole = $user->roles->first();
        if(($CurrentRole != null && $CurrentRole->name === "super admin") or ($request->name === "super admin"))
        {
            return  $this->NowRedirectTo('/admin/users/',
                '/emiweb/users/',
                'Are you really trying to update super admin?'
            );

        }else{

            //  return Carbon::now()->addYear();
            // redirect to user list with you cant do that message
            if($request->name == "subscriber" or $request->name == "organizational subscriber")
            {
                $user->update(['manual_expire' => Carbon::now()->addYear()]);
            }else
            {
                $user->update(['manual_expire' => null]);
            }
            $user->syncRoles([$request->name]);
            
            return  $this->NowRedirectTo('/admin/users/',
                '/emiweb/users/',
                'User updated'
            );
        }
    }

    /**
     * List all subscribers
     * @return Application|Factory|View
     */
    public function subscribers()
    {
        $manualSubscriptions = User::role('subscriber')
            ->whereNotNull('manual_expire')
            ->where('manual_expire', '>=', Carbon::now())
            ->get();
        //        return $manualSubscriptions;
        $subscriptions =  Subscription::query()->with('user')->active()->get();
        //        return $subscriptions;
        return view('admin.users.subscriptions', compact('subscriptions', 'manualSubscriptions'));
    }

    /**
     * Cancel subscription for a user
     * @param User $user
     * @return RedirectResponse
     */
    public function subscriptionCancel(User $user)
    {
        $sub_name = $user->subscriptions->first()->name;
        $user->subscription($sub_name)->cancel();
        return redirect()->back()->with('Success', 'Subscription is now cancelled');
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
