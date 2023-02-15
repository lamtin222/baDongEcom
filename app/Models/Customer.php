<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;

/**
 * @OA\Schema(
 *      schema="Customer",
 *      required={},
 *      @OA\Property(
 *          property="username",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="phone_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="name",
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
 *          property="remember_token",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="email_verified_at",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="facebook_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="google_id",
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
 */
class Customer extends Authenticatable implements InstanceIdentifier
{
    use HasApiTokens, HasFactory, Notifiable;
    public $table = 'customers';

    public $fillable = [
        'username',
        'password',
        'email',
        'phone_number',
        'avatar',
        'name',
        'address',
        'remember_token',
        'email_verified_at',
        'facebook_id',
        'google_id',
        "store_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'username' => 'string',
        'password' => 'string',
        'email' => 'string',
        'phone_number' => 'string',
        'avatar'=>'string',
        'name' => 'string',
        'address' => 'string',
        'remember_token' => 'string',
        'email_verified_at' => 'datetime',
        'facebook_id' => 'string',
        'google_id' => 'string'
    ];

    public static $rules = [
        'username' => 'nullable|string',
        'password' => 'nullable|string',
        'email' => 'nullable|string',
        'phone_number' => 'nullable|string',
        'avatar'=>"nullable|file|mime:jpg,jpeg,png|max:5*1024",
        'name' => 'nullable|string',
        'address' => 'nullable|string',
        'remember_token' => 'nullable|string',
        'email_verified_at' => 'nullable',
        'facebook_id' => 'nullable|string',
        'google_id' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    /**
     * Get all of the bank account for the Customer
     *
     *
     */
    public function bankAccounts()
    {
        return $this->morphMany(BankAccount::class,'bankAccountable');
    }
    public function addresses()
    {
        return $this->morphMany(Address::class,'addressable');
    }

    /**
     * The Store that belong to the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the unique identifier to load the Cart from
     *
     * @return int|string
     */
    public function getInstanceIdentifier($options = null)
    {
        return $this->email;
    }
    public function getInstanceGlobalDiscount($options = null)
    {
        return $this->discountRate ?: 0;
    }
}
