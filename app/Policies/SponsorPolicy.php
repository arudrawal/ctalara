<?php

namespace App\Policies;

use App\Models\Sponsor;
use App\Models\User;
use App\Models\SponsorUserProfile;
//use App\Models\StudyUserProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class SponsorPolicy
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
     * @param  \App\Models\Sponsor  $sponsor
     * @return mixed
     */
    public function view(User $user, Sponsor $sponsor)
    {
        $sponsor_user_profile = SponsorUserProfile::where('user_id', $user->id)
                                ->andWhere('sponsor_id', $sponsor->id)
                                ->first();
        if ($sponsor_user_profile) {
            //$sponsor_user_profile->permissions();
            SponsorProfilePermission::where('sponsor_profile_id', $sponsor_user_profile->sponsor_profile_id)
                                    ->andWhere('secure_model_id', )
                                    ->first();
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sponsor  $sponsor
     * @return mixed
     */
    public function update(User $user, Sponsor $sponsor)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sponsor  $sponsor
     * @return mixed
     */
    public function delete(User $user, Sponsor $sponsor)
    {
        return false; // sponsor level admin - no delete
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sponsor  $sponsor
     * @return mixed
     */
    public function restore(User $user, Sponsor $sponsor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sponsor  $sponsor
     * @return mixed
     */
    public function forceDelete(User $user, Sponsor $sponsor)
    {
        //
    }
}
