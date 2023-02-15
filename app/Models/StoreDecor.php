<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="StoreDecor",
 *      required={},
 *      @OA\Property(
 *          property="background_color",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="background_image",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="text_color",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="main_color",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="sub_color",
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
 */class StoreDecor extends Model
{
    public $table = 'store_decors';

    public $fillable = [
        'store_id',
        'background_color',
        'background_image',
        'text_color',
        'main_color',
        'sub_color'
    ];

    protected $casts = [
        'background_color' => 'string',
        'background_image' => 'string',
        'text_color' => 'string',
        'main_color' => 'string',
        'sub_color' => 'string'
    ];

    public static $rules = [
        'store_id' => 'nullable',
        'background_color' => 'nullable|string',
        'background_image' => 'nullable|string',
        'text_color' => 'nullable|string',
        'main_color' => 'nullable|string',
        'sub_color' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    /**
     * Get the Store that owns the StoreDecor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Store::class);
    }


}
