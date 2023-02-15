<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;

/**
 * @OA\Schema(
 *      schema="Product",
 *      required={},
 *      @OA\Property(
 *          property="sku",
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
 *          property="description",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="body",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="images",
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
 */class Product extends Model
{
    use HasFactory;
    public $table = 'products';

    public $fillable = [
        'category_id',
        'sku',
        'name',
        'description',
        'body',
        'images'
    ];

    protected $casts = [
        'sku' => 'string',
        'name' => 'string',
        'description' => 'string',
        'body' => 'string',
        'images' => 'string'
    ];

    public static $rules = [
        'category_id' => 'nullable',
        'sku' => 'nullable|string',
        'name' => 'nullable|string',
        'description' => 'nullable|string',
        'body' => 'nullable|string',
        'images' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    protected $appends = ['full_images'];
    /**
     * Get the Category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StoreCategory::class,'category_id','id');
    }
    /**
     * Get all of the variants for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productVariants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    /**
     * Get the Rate associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Rate():  \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductRate::class);
    }
    function getFullImagesAttribute() {
       $images = json_decode($this->images);
       $arr=[];
        if($images)
            foreach($images as $image)
               if( !filter_var($image, FILTER_VALIDATE_URL))
                    $arr[]=Voyager::image( $image );
               else
                    $arr[] = $image;
        return $arr;
      }


}
