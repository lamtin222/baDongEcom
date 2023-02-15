<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="StoreBalance",
 *      required={},
 *      @OA\Property(
 *          property="type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="add_subtract",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="current_date",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date-time"
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
 */class StoreBalance extends Model
{
    public $table = 'store_balances';

    public $fillable = [
        'store_id',
        'order_id',
        'type',
        'old_balance',
        'new_balance',
        'current_balance',
        'add_subtract',
        'current_date'
    ];

    protected $casts = [
        'type' => 'string',
        'add_subtract' => 'string',
        'current_date' => 'datetime'
    ];

    public static $rules = [
        'store_id' => 'nullable',
        'order_id' => 'nullable',
        'type' => 'nullable|string',
        'old_balance' => 'nullable',
        'new_balance' => 'nullable',
        'current_balance' => 'nullable',
        'add_subtract' => 'nullable|string',
        'current_date' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
