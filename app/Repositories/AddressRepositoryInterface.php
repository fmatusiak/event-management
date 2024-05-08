<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface AddressRepositoryInterface
{
    public function searchAddressesByKeywords(string $keywords, int $perPage = 15): LengthAwarePaginator;
}
