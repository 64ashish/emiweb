<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Organization $organization)
    {
        //
        if ($user->hasRole(['emiweb admin', 'emiweb staff'])) {
            return true;
        }
        if($user->hasRole(['organization admin']) and $user->organization_id === $organization->id){
            return true;
        }
        return false;
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
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Organization $organization)
    {
        //
        if ($user->hasRole(['emiweb admin', 'emiweb staff'])) {
            return true;
        }
        if($user->hasRole(['organization admin']) and $user->organization_id === $organization->id){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Organization $organization)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Organization $organization)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Organization $organization)
    {
        //
    }

    /**
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function viewAssociations(User $user, Organization $organization)
    {
        if($user->hasRole(['emiweb admin', 'emiweb staff']))
        {
            return true;
        }
        if($user->hasRole('organization admin') and $user->organization_id === $organization->id)
        {
            return true;
        }
        return false;
    }

    public function approveAssociation(User $user, Organization $organization)
    {
//        if you are from emiweb
        if($user->hasRole(['emiweb admin', 'emiweb staff']))
        {
            return true;
        }
//        if you are organization admin
        if($user->hasRole('organization admin') and $user->organization_id === $organization->id)
        {
            return true;
        }
//        everyone else
        return false;
    }
}
