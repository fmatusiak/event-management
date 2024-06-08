<?php

namespace App\Repositories;

use App\Models\Cost;
use Illuminate\Pagination\LengthAwarePaginator;

class CostRepository extends BasicRepository implements BasicRepositoryInterface
{
    public function __construct(Cost $cost)
    {
        parent::__construct($cost);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        return $query->paginate($perPage, $columns);
    }
}
