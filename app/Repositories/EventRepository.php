<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class EventRepository extends BasicRepository implements BasicRepositoryInterface
{
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    public function paginate(array $filters = [], int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $query = $this->model::query();

        if ($eventName = Arr::get($filters, 'event_name')) {
            $query = $query->where("event_name", "like", "%$eventName%");
        }

        if ($startTime = Arr::get($filters, 'start_time')) {
            $query = $query->where("start_time", ">=", $startTime);
        }

        if ($endTime = Arr::get($filters, 'end_time')) {
            $query = $query->where("end_time", "<=", $endTime);
        }

        $query = $query->orderBy('start_time');

        $query = $query->with('client', 'clientAddress', 'deliveryAddress');

        return $query->paginate($perPage, $columns);
    }
}
