<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class PackageRepository extends BasicRepository implements BasicRepositoryInterface
{
    public function __construct(Package $package)
    {
        parent::__construct($package);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($name = Arr::get($filters, 'name')) {
            $query = $query->where("name", "like", "%$name%");
        }

        return $query->paginate($perPage, $columns);
    }
}
