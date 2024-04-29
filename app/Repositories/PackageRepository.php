<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class PackageRepository implements BasicRepositoryInterface
{
    private Package $package;

    public function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->package::query();

        if ($name = Arr::get($filters, 'name')) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->paginate($perPage, $columns);
    }

    public function get(int $id): Package
    {
        return $this->package::findOrFail($id);
    }

    public function create(array $data): Package
    {
        return $this->package::create($data);
    }

    public function update(int $id, array $data): Package
    {
        $package = $this->get($id);
        $package->update($data);

        return $package;
    }

    public function delete(int $id): bool
    {
        $package = $this->get($id);
        return $package->delete();
    }
}
