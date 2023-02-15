<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'slug',
        'oder',
        'parent_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Category::class;
    }
}
