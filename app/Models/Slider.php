<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $table = 'sliders';

    public $fillable = [
        'title',
        'image',
        'link',
        'order',
        'is_enable'
    ];

    protected $casts = [
        'title' => 'string',
        'image' => 'string',
        'link' => 'string',
        'order' => 'integer',
        'is_enable' => 'integer'
    ];

    public static $rules = [
        'title' => 'required',
        'link' => 'required',
        'image'=>'nullable|file|max:5120|mimes:jpg,jpeg,bmp,png'
    ];


}
