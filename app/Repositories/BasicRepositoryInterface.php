<?php

namespace App\Repositories;

interface BasicRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']);

    public function create(array $data);

    public function update(int $id, array $data);

    public function get(int $id);

    public function delete(int $id);
}
