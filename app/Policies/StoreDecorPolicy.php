<?php

namespace App\Policies;

use App\Models\StoreDecor;
use App\Models\Customer as User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreDecorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreDecor  $storeDecor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, StoreDecor $storeDecor)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(?User $user)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id)?true:false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreDecor  $storeDecor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?User $user, StoreDecor $storeDecor)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id==$storeDecor->store_id)?true:false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreDecor  $storeDecor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?User $user, StoreDecor $storeDecor)
    {
        $cus=auth('sanctum')->user();
        return ($cus->store_id==$storeDecor->store_id)?true:false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreDecor  $storeDecor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(?User $user, StoreDecor $storeDecor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StoreDecor  $storeDecor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(?User $user, StoreDecor $storeDecor)
    {
        //
    }
}
