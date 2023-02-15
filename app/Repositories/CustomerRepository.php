<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'username',
        'password',
        'email',
        'phone_number',
        'name',
        'address',
        'remember_token',
        'email_verified_at',
        'facebook_id',
        'google_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Customer::class;
    }
}
