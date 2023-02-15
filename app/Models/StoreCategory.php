<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCG\Voyager\Facades\Voyager;
/**
 * @OA\Schema(
 *      schema="StoreCategory",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
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
 *          property="slug",
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
 */class StoreCategory extends Model
{
    use HasFactory;
    public $table = 'store_categories';

    public $fillable = [
        'store_id',
        'grand_id',
        'name',
        'image',
        'slug'
    ];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'slug' => 'string'
    ];

    public static $rules = [
        'store_id' => 'nullable',
        'grand_id' => 'nullable',
        'name' => 'nullable|string',
        'image' => 'nullable',
        'slug' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    protected $appends = ['full_image'];
    public function store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Store::class, 'store_id');
    }
    /**
     * Get all of the products for the StoreCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

     /**
      * Get the GrandCategory that owns the StoreCategory
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function GrandCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
     {
         return $this->belongsTo(GrandCategory::class,'grand_id','id');
     }
     function getFullImageAttribute() {
        if( !filter_var($this->image, FILTER_VALIDATE_URL))
        return Voyager::image( $this->image );
        return $this->image;
      }
}
