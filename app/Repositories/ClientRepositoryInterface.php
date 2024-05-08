<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    public function searchClientsByKeywords(string $keywords, int $perPage = 15): LengthAwarePaginator;
}
