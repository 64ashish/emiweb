<?php

namespace App\Policies;

use App\Models\DenmarkEmigration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DenmarkEmigrationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole(['super admin','emiweb admin', 'emiweb staff'])) {
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
        //



    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DenmarkEmigration  $denmarkEmigration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DenmarkEmigration $denmarkEmigration)
    {
        //
        if($user->hasRole(['organization admin', 'organization staff']) and $user->organization->archives->contains('id', 1))
        {
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
        if($user->hasRole(['organization admin', 'organization staff']) and $user->organization->archives->contains('id', 1))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DenmarkEmigration  $denmarkEmigration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DenmarkEmigration $denmarkEmigration)
    {
        //
        if($user->hasRole(['organization admin', 'organization staff']) and $user->organization->archives->contains('id', 1))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DenmarkEmigration  $denmarkEmigration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DenmarkEmigration $denmarkEmigration)
    {
        //

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DenmarkEmigration  $denmarkEmigration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DenmarkEmigration $denmarkEmigration)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DenmarkEmigration  $denmarkEmigration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DenmarkEmigration $denmarkEmigration)
    {
        //
    }
}
