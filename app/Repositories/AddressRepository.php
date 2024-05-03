<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class AddressRepository extends BasicRepository implements BasicRepositoryInterface
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($street = Arr::get($filters, 'street')) {
            $query = $query->where("street", "LIKE", "%$street%");
        }

        if ($city = Arr::get($filters, 'city')) {
            $query = $query->where("city", "LIKE", "%$city%");
        }

        if ($postcode = Arr::get($filters, 'postcode')) {
            $query = $query->where("postcode", "LIKE", "%$postcode%");
        }

        return $query->paginate($perPage, $columns);
    }
}
