<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\BaseRepository;

class SliderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'image',
        'link',
        'order',
        'is_enable'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Slider::class;
    }
}
