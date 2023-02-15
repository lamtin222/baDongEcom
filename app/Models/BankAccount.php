<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="BankAccount",
 *      required={},
 *      @OA\Property(
 *          property="accountable_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="branch",
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
 *          property="ccv",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_number",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="bank_expire",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *          format="date"
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
 */class BankAccount extends Model
{
    public $table = 'bank_accounts';

    public $fillable = [
        'accountable_type',
        'accountable_id',
        'is_default',
        'bank_type',
        'branch',
        'name',
        'ccv',
        'bank_number',
        'bank_expire'
    ];

    protected $casts = [
        'accountable_type' => 'string',
        'bank_type' => 'string',
        'branch' => 'string',
        'name' => 'string',
        'ccv' => 'string',
        'bank_number' => 'string',
        'bank_expire' => 'date'
    ];

    public static $rules = [
        'accountable_type' => 'nullable|string',
        'accountable_id' => 'nullable',
        'is_default' => 'nullable',
        'bank_type' => 'nullable|string',
        'branch' => 'nullable|string',
        'name' => 'nullable|string',
        'ccv' => 'nullable|string',
        'bank_number' => 'nullable|string',
        'bank_expire' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    public function bankAccountable()
    {
        return $this->morphTo(__FUNCTION__, 'accountable_type', 'accountable_id');
    }

}
