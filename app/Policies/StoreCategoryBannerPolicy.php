<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\StoreCategoryBanner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreCategoryBannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?Customer $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategoryBanner  $storeCategoryBanner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?Customer $user, StoreCategoryBanner $storeCategoryBanner)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(?Customer $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategoryBanner  $storeCategoryBanner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?Customer $user, StoreCategoryBanner $storeCategoryBanner)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategoryBanner  $storeCategoryBanner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?Customer $user, StoreCategoryBanner $storeCategoryBanner)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategoryBanner  $storeCategoryBanner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(?Customer $user, StoreCategoryBanner $storeCategoryBanner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategoryBanner  $storeCategoryBanner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(?Customer $user, StoreCategoryBanner $storeCategoryBanner)
    {
        //
    }
}
