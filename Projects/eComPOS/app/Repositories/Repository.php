<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    abstract public static function model();

    public static function query(): Builder
    {
        return static::model()::query();
    }

    public static function getAll(): Collection
    {
        return static::model()::latest()->get();
    }

    /**
     * @return Builder|Model|object|null
     */
    public static function first(): Model|null
    {
        return static::query()->first();
    }

    /**
     * @return Builder|Builder[]|Collection|Model|null|mixed
     */
    public static function find($primaryKey): Model|null
    {
        return static::query()->find($primaryKey);
    }

    /**
     * @return Builder|Builder[]|Collection|Model|null|mixed
     */
    public static function findOrFail($primaryKey)
    {
        return static::query()->findOrFail($primaryKey);
    }

    public static function delete($primaryKey): bool
    {
        return static::model()::destroy($primaryKey);
    }

    /**
     * @return Builder|Model|mixed
     */
    public static function create(array $data): Model
    {
        return static::query()->create($data);
    }

    /**
     * @return bool
     */
    public static function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }
}
