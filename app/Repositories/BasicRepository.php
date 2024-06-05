<?php

namespace App\Repositories;

class BasicRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->get($id);
        $model->update($data);

        return $model;
    }

    public function get(int $id)
    {
        return $this->model::findOrFail($id);
    }

    public function delete(int $id): bool
    {
        $model = $this->get($id);
        return $model->delete();
    }

    public function updateOrCreate(array $attributes, array $values = []){
        return $this->model::updateOrCreate($attributes, $values);
    }
}
