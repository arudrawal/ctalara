<?php

namespace App\Policies;

use App\Models\Protocol;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProtocolPolicy
{
    use HandlesAuthorization;
    
    public function before(User $user, $ability)
    {
        if ($user->profile) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Protocol  $protocol
     * @return mixed
     */
    public function view(User $user, Protocol $protocol)
    {
        if ($user->profile) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Protocol  $protocol
     * @return mixed
     */
    public function update(User $user, Protocol $protocol)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Protocol  $protocol
     * @return mixed
     */
    public function delete(User $user, Protocol $protocol)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Protocol  $protocol
     * @return mixed
     */
    public function restore(User $user, Protocol $protocol)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Protocol  $protocol
     * @return mixed
     */
    public function forceDelete(User $user, Protocol $protocol)
    {
        //
    }
}
