<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClientRepository extends BasicRepository implements BasicRepositoryInterface, ClientRepositoryInterface
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function searchClientsByKeywords(string $keywords, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model::query();

        $keywordArray = explode(' ', $keywords);

        foreach ($keywordArray as $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('first_name', 'LIKE', "%$keyword%")
                    ->orWhere('last_name', 'LIKE', "%$keyword%")
                    ->orWhere('pesel', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('phone', 'LIKE', "%$keyword%");
            });
        }

        return $query->paginate($perPage);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($name = Arr::get($filters, 'name')) {
            $query = $query->where(DB::raw("CONCAT(first_name,' ',last_name,' - email: ',email,' - phone: ',phone)"), "LIKE", "%$name%");
        }

        if ($pesel = Arr::get($filters, 'pesel')) {
            $query = $query->where("pesel", "LIKE", "%$pesel%");
        }

        if ($email = Arr::get($filters, 'email')) {
            $query = $query->where("email", "LIKE", "%$email%");
        }

        if ($phone = Arr::get($filters, 'phone')) {
            $query = $query->where("phone", "LIKE", "%$phone%");
        }

        return $query->paginate($perPage, $columns);
    }
}
