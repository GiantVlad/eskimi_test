<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function get(int $id): Model;

    /**
     * @param int $limit
     * @return Paginator
     * @throws ModelNotFoundException
     */
    public function getList(int $limit): Paginator;
}
