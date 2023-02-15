<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $table = 'wards';

    public $fillable = [
        'name',
        'type',
        'district_id'
    ];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'type' => 'string',
        'district_id' => 'string'
    ];

    public static $rules = [
        'name' => 'required|string',
        'type' => 'required|string',
        'district_id' => 'required|string'
    ];

    public function district(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\District::class, 'district_id');
    }
}
