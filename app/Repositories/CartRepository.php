<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\BaseRepository;

class CartRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'qty',
        'customer_id',
        'product_id',
        'variant_id',
        'disamount',
        'distype',
        'semi_total',
        'price_total',
        'ori_price',
        'ori_offer_price',
        'tax_amount',
        'tax_type',
        'ship_type',
        'store_id',
        'shipping',
        'coupan_id',
        'gift_pkg_charge'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Cart::class;
    }
}
