<?php

namespace App\Repositories;

use App\Models\CustomerBalance;
use App\Repositories\BaseRepository;

class CustomerBalanceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'customer_id',
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
        return CustomerBalance::class;
    }
}
