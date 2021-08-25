<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{
    protected const LIMIT = 15;

    public function __construct(protected Model $model)
    {
    }

    /**
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function get(int $id): Model
    {
        /** @var Model $model */
        $model = $this->model->findOrFail($id);

        return $model;
    }

    /**
     * @param int $limit
     * @return Paginator
     */
    public function getList(int $limit = self::LIMIT): Paginator
    {
        return $this->model->newQuery()->simplePaginate($limit);
    }

    /**
     * @param array $ids
     */
    public function removeMany(array $ids): void
    {
        $this->model->newQuery()->whereIn('id', $ids)->delete();
    }
}
