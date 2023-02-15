<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Page",
 *      required={"status","menu","title","slug"},
 *      @OA\Property(
 *          property="status",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="menu",
 *          description="",
 *          readOnly=false,
 *          nullable=false,
 *          type="boolean",
 *      ),
 *      @OA\Property(
 *          property="title",
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
 *          property="content",
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
 *          property="images",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="layout",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="seo",
 *          description="",
 *          readOnly=false,
 *          nullable=true,
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="details",
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
 */class Page extends Model
{
    public $table = 'pages';

    public $fillable = [
        'parent_id',
        'status',
        'menu',
        'title',
        'slug',
        'content',
        'image',
        'images',
        'layout',
        'order',
        'seo',
        'details'
    ];

    protected $casts = [
        'status' => 'boolean',
        'menu' => 'boolean',
        'title' => 'string',
        'slug' => 'string',
        'content' => 'string',
        'image' => 'string',
        'images' => 'string',
        'layout' => 'string',
        'seo' => 'string',
        'details' => 'string'
    ];

    public static $rules = [
        'parent_id' => 'nullable',
        'status' => 'required|boolean',
        'menu' => 'required|boolean',
        'title' => 'required|string',
        'slug' => 'required|string|unique:pages,slug',
        'content' => 'nullable|string',
        'image' => 'nullable|string',
        'images' => 'nullable|string',
        'layout' => 'nullable|string',
        'order' => 'nullable',
        'seo' => 'nullable|string',
        'details' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


}
