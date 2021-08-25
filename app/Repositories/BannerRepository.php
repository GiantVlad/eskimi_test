<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository extends BaseRepository
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }
}
