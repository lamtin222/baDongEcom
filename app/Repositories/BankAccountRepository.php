<?php

namespace App\Repositories;

use App\Models\BankAccount;
use App\Repositories\BaseRepository;

class BankAccountRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'accountable_type',
        'accountable_id',
        'is_default',
        'bank_type',
        'branch',
        'name',
        'ccv',
        'bank_number',
        'bank_expire'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return BankAccount::class;
    }
}
