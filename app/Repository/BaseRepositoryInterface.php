<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @param $id
     * @return bool
     */
    public function update(array $attributes, $id): bool;

    /**
     * @param array $attributes
     * @return Model
     */
    public function updateOrCreate(array $attributes): Model;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model;

    /**
     * @return Builder
     */
    public function getQueryBuilder(): Builder;
}
