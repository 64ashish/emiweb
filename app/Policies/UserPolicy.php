<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('super admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {

        //        do stuff if emiweb admin and staff
        if ($user->hasRole(['emiweb admin', 'emiweb staff'])) {
            return true;
        }

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
        if ($user->hasRole(['emiweb admin', 'emiweb staff'])) {
            return true;
        }


    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        if ($user->hasRole(['emiweb admin', 'emiweb staff'])) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {

    //        only edit your detail
        if( $user->id === $model->id)
        {
            return true;
        }
        // do stuff if admin
        if($user->hasRole('emiweb admin')){
            return true;
        }
//        for organization admin
        if($user->hasRole('organization admin') and ($user->organization_id === $model->organization_id))
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function syncRole(User $user, User $model)
    {

//      if you are emiweb admin, do what you want
        if($user->hasRole('emiweb admin')){  return true; }
//      todos
//      if you are admin in your organization, you can update your staffs only
        if( $user->hasRole('organization admin') & ($user->organization_id === $model->organization_id) ){
            return true;

        }
        return false;




    }

    public function syncWithOrganization(User $user, User $model)
    {
//        allow if emiadmin or emistaff
        if($user->hasRole(['emiweb admin', 'emiweb staff']))
            {
                return true;
            }
//        allow only for organization staffs
        if( ($user->hasRole('organization admin') and auth()->user()->id !== $model->id) and ($user->organization_id === $model->organization_id) )
            {
                return true;
            }

        return false;
    }



}
