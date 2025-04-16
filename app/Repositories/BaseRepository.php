<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function query()
    {
        return $this->model::query();
    }
}
