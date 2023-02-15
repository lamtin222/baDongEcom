<?php

namespace App\Repositories;

use App\Models\ProductRate;
use App\Repositories\BaseRepository;

class ProductRateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'product_id',
        'rate',
        'avg_rate',
        'total'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ProductRate::class;
    }
}
