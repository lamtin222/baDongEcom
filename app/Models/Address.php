<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Address",
 *      required={},
 *      @OA\Property(
 *          property="address",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="ward_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="is_default",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="addressable_type",
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
 */class Address extends Model
{
    public $table = 'addresses';

    public $fillable = [
        'address',
        'full_address',
        'ward_id',
        'is_default',
        'addressable_id',
        'addressable_type'
    ];

    protected $casts = [
        'address' => 'string',
        'ward_id' => 'string',
        'is_default' => 'boolean',
        'addressable_type' => 'string'
    ];

    public static $rules = [
        'address' => 'nullable|string',
        'full_address' => 'nullable',
        'ward_id' => 'nullable|string',
        'is_default' => 'nullable|boolean',
        'addressable_id' => 'nullable',
        'addressable_type' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    public function addressable()
    {
        return $this->morphTo();
    }


}
