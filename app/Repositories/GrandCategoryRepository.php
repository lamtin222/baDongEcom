<?php

namespace App\Repositories;

use App\Models\GrandCategory;
use App\Repositories\BaseRepository;

class GrandCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'icon',
        'slug',
        'color'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return GrandCategory::class;
    }
}
