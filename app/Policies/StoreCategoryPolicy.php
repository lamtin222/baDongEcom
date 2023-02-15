<?php

namespace App\Policies;

use App\Models\StoreCategory;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreCategoryPolicy
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
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?Customer $user, StoreCategory $storeCategory)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id==$storeCategory->store_id)?true:false;
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
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?Customer $user, StoreCategory $storeCategory)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id==$storeCategory->store_id)?true:false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?Customer $user, StoreCategory $storeCategory)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id==$storeCategory->store_id)?true:false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(?Customer $user, StoreCategory $storeCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreCategory  $storeCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(?Customer $user, StoreCategory $storeCategory)
    {
        $cus=auth('sanctum')->user();
        return ($cus?->store_id==$storeCategory?->store_id)?true:false;
    }
}
