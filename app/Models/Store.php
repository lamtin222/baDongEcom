<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      schema="Store",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="banner",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="address",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="",
 *          readOnly=true,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */class Store extends Model
{
    use HasFactory;
    public $table = 'stores';

    public $fillable = [
        'name',
        'banner',
        'address',
        'description'
    ];
    protected $hidden = [
        'laravel_through_key'
     ];

    protected $casts = [
        'name' => 'string',
        'banner' => 'string',
        'address' => 'string',
        'description' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string|unique:stores,name',
        'banner' => 'nullable|string',
        'address' => 'nullable|string',
        'description' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function storeCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\StoreCategory::class, 'store_id');
    }


    /**
     * Get all of the products for the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, StoreCategory::class,'store_id','category_id','id','id');
    }

    /**
     * Get all of the customers for the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Customer::class);
    }
    /**
     * Get the Owner that owns the Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Owner()
    {
        return $this->belongsTo(Customer::class,'owner_id','id');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class,'addressable');
    }
    public function bankAccounts()
    {
        return $this->morphMany(BankAccount::class,'bankAccountable');
    }
}
