<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\BaseRepository;

class DistrictRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'type',
        'province_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return District::class;
    }
}
