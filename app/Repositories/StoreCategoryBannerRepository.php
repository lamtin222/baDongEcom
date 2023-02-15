<?php

namespace App\Repositories;

use App\Models\StoreCategoryBanner;
use App\Repositories\BaseRepository;

class StoreCategoryBannerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'category_id',
        'title',
        'image',
        'link'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return StoreCategoryBanner::class;
    }
}
