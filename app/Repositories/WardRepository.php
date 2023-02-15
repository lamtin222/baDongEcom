<?php

namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\BaseRepository;

class WardRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'type',
        'district_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Ward::class;
    }
}
