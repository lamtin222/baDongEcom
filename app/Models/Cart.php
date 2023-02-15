<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Cart",
 *      required={},
 *      @OA\Property(
 *          property="qty",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="customer_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="variant_id",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="disamount",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="distype",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="semi_total",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="double",
 *      ),
 *      @OA\Property(
 *          property="price_total",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="double",
 *      ),
 *      @OA\Property(
 *          property="ori_price",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="double",
 *      ),
 *      @OA\Property(
 *          property="tax_type",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="ship_type",
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
 */class Cart extends Model
{
    public $table = 'carts';

    public $fillable = [
        'qty',
        'customer_id',
        'product_id',
        'variant_id',
        'disamount',
        'distype',
        'semi_total',
        'price_total',
        'ori_price',
        'ori_offer_price',
        'tax_amount',
        'tax_type',
        'ship_type',
        'store_id',
        'shipping',
        'coupan_id',
        'gift_pkg_charge'
    ];

    protected $casts = [
        'distype' => 'string',
        'tax_type' => 'string',
        'ship_type' => 'string'
    ];

    public static $rules = [
        'qty' => 'required|min:1|numeric',
        'customer_id' => 'nullable',
        'product_id' => 'required',
        'variant_id' => 'required',
        'disamount' => 'nullable',
        'distype' => 'nullable|string',
        'semi_total' => 'nullable',
        'price_total' => 'nullable',
        'ori_price' => 'nullable',
        'ori_offer_price' => 'nullable',
        'tax_amount' => 'nullable',
        'tax_type' => 'nullable|string',
        'ship_type' => 'nullable|string',
        'store_id' => 'nullable',
        'shipping' => 'nullable',
        'coupan_id' => 'nullable',
        'gift_pkg_charge' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    /**
     * Get the Product that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    /**
     * Get the ProductVariant that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ProductVariant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'variant_id','id');
    }
    /**
     * Get the Store that owns the Cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Store()
    {
        return $this->belongsTo(Store::class);
    }


}
