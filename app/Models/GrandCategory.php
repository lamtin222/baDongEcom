<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCG\Voyager\Facades\Voyager;
/**
 * @OA\Schema(
 *      schema="GrandCategory",
 *      required={},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="icon",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="color",
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
 */class GrandCategory extends Model
{
    use HasFactory;
    public $table = 'grand_categories';

    public $fillable = [
        'name',
        'icon',
        'color'
    ];

    protected $casts = [
        'name' => 'string',
        'icon' => 'string',
        'color' => 'string'
    ];

    public static $rules = [
        'name' => 'nullable|string',
        'icon' => 'nullable|string',
        'color' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
    protected $appends = ['full_icon'];

    /**
     * Get all of the storeCategories for the GrandCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storeCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StoreCategory::class,'grand_id','id');
    }

    /**
     * Get all of the products for the Store
     *
     * @return HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, StoreCategory::class,'grand_id','category_id','id','id');
    }
    function getFullIconAttribute() {
        if( !filter_var($this->icon, FILTER_VALIDATE_URL))
        return Voyager::image( $this->icon );
        return $this->icon;
      }
}
