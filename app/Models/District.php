<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $table = 'districts';

    public $fillable = [
        'name',
        'type',
        'province_id'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'type' => 'string',
        'province_id' => 'string'
    ];

    public static $rules = [
        'name' => 'required|string',
        'type' => 'required|string',
        'province_id' => 'required|string'
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Province::class, 'province_id');
    }

    public function wards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Ward::class, 'district_id');
    }
}
