<?php

namespace App\Repositories;

use App\Models\ProductVariant;
use App\Repositories\BaseRepository;

class ProductVariantRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'product_id',
        'name',
        'image',
        'sku',
        'price',
        'is_default',
        'width',
        'long',
        'height',
        'weight'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ProductVariant::class;
    }
}
