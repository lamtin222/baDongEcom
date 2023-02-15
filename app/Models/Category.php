<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Category",
 *      required={"name","slug","oder","parent_id"},
 *      @OA\Property(
 *          property="name",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="slug",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
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
 */class Category extends Model
{
    public $table = 'categories';

    public $fillable = [
        'name',
        'slug',
        'oder',
        'parent_id'
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string'
    ];

    public static $rules = [
        'name' => 'required|string',
        'slug' => 'required|string',
        'oder' => 'required',
        'parent_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


}
