<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class AddressRepository extends BasicRepository implements BasicRepositoryInterface, AddressRepositoryInterface
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }

    public function searchAddressesByKeywords(string $keywords, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model::query();

        $keywordArray = explode(' ', $keywords);

        foreach ($keywordArray as $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('street', 'LIKE', "%$keyword%")
                    ->orWhere('city', 'LIKE', "%$keyword%")
                    ->orWhere('postcode', 'LIKE', "%$keyword%");
            });
        }

        return $query->paginate($perPage);
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
