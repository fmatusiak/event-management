<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClientRepository extends BasicRepository implements BasicRepositoryInterface
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($name = Arr::get($filters, 'name')) {
            $query = $query->where(DB::raw("CONCAT(first_name,' ',last_name)"), "LIKE", "%$name%");
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
