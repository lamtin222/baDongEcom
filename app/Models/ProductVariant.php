<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Gloudemans\Shoppingcart\CanBeBought;
use TCG\Voyager\Facades\Voyager;


/**
 * @OA\Schema(
 *      schema="ProductVariant",
 *      required={"product_id","name","price","width","long","height","weight"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="image",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="sku",
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
class ProductVariant extends Model implements Buyable
{
    use CanBeBought;
    use HasFactory;
    public $table = 'product_variants';

    public $fillable = [
        'product_id',
        'name',
        'image',
        'sku',
        'price',
        'is_default',
        'width',
        'long',
        'height',
        'weight'
    ];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'sku' => 'string'
    ];

    public static $rules = [
        'product_id' => 'required',
        'name' => 'required|string',
        'image' => 'nullable|string',
        'sku' => 'nullable|string',
        'price' => 'required',
        'is_default' => 'nullable',
        'width' => 'required',
        'long' => 'required',
        'height' => 'required',
        'weight' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    protected $appends = ['full_image'];
    /**
     * Get the Product that owns the ProductVariant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getBuyableIdentifier($options = null){
        return $this->id;
    }
    public function getBuyableDescription($options = null){
        return $this->name;
    }
    public function getBuyablePrice($options = null){
        return $this->price;
    }
    public function getBuyableWeight($options = null){
        return $this->weight;
    }
    function getFullImageAttribute() {
        if( !filter_var($this->image, FILTER_VALIDATE_URL))
        return Voyager::image( $this->image );
        return $this->image;
      }
}
