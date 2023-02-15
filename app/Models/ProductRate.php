<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;

/**
 * @OA\Schema(
 *      schema="ProductRate",
 *      required={},
 *      @OA\Property(
 *          property="rate",
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
 */class ProductRate extends Model
{
    public $table = 'product_rates';

    public $fillable = [
        'product_id',
        'rate',
        'avg_rate',
        'total'
    ];

    protected $casts = [
        'rate' => AsCollection::class,
    ];

    public static $rules = [
        'product_id' => 'nullable',
        'rate' => 'nullable',
        'avg_rate' => 'nullable',
        'total' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    /**
     * Get the Product that owns the ProductRate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Product():  \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    
}
