<?php

namespace App\Repositories\Admin;

use App\Models\Page;
use App\Repositories\BaseRepository;

class PageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'parent_id',
        'status',
        'menu',
        'title',
        'slug',
        'content',
        'image',
        'images',
        'layout',
        'order',
        'seo',
        'details'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Page::class;
    }
}
