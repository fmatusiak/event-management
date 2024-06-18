<?php

namespace App\Repositories;

use App\Models\Email;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class EmailRepository extends BasicRepository
{
    public function __construct(Email $email)
    {
        parent::__construct($email);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($eventIds = Arr::get($filters, 'event_ids')) {
            $eventIds = explode(',', $eventIds);

            $query->whereIn('event_id', $eventIds);
        }

        $query = $query->orderByDesc('created_at');

        return $query->paginate($perPage, $columns);
    }

}
