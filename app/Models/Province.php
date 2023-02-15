<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $table = 'provinces';

    public $fillable = [
        'name',
        'type'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'type' => 'string'
    ];

    public static $rules = [
        'name' => 'required|string',
        'type' => 'required|string'
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function districts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\District::class, 'province_id');
    }
}
