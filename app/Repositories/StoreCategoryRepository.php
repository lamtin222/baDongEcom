<?php

namespace App\Repositories;

use App\Models\StoreCategory;
use App\Repositories\BaseRepository;

class StoreCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'store_id',
        'grand_id',
        'name',
        'image',
        'slug'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return StoreCategory::class;
    }
}
