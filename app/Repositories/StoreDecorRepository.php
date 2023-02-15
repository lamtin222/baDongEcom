<?php

namespace App\Repositories;

use App\Models\StoreDecor;
use App\Repositories\BaseRepository;

class StoreDecorRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'store_id',
        'background_color',
        'background_image',
        'text_color',
        'main_color',
        'sub_color'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return StoreDecor::class;
    }
}
