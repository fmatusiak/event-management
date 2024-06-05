<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface BasicRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function create(array $data);

    public function update(int $id, array $data);

    public function get(int $id);
    public function updateOrCreate(array $attributes, array $values = []);

    public function delete(int $id);
}
