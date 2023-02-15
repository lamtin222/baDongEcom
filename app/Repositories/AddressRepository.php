<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'address',
        'full_address',
        'ward_id',
        'is_default',
        'addressable_id',
        'addressable_type'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Address::class;
    }
}
