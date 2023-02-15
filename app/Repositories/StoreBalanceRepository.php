<?php

namespace App\Repositories;

use App\Models\StoreBalance;
use App\Repositories\BaseRepository;

class StoreBalanceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'store_id',
        'order_id',
        'type',
        'old_balance',
        'new_balance',
        'current_balance',
        'add_subtract',
        'current_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return StoreBalance::class;
    }
}
