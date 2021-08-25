<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CampaignRequestDTO;
use App\Models\Campaign;
use Illuminate\Contracts\Pagination\Paginator;

class CampaignRepository extends BaseRepository
{
    public function __construct(Campaign $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $limit
     * @return Paginator
     */
    public function getList(int $limit = self::LIMIT): Paginator
    {
        return $this->model->newQuery()->with('banners')->simplePaginate($limit);
    }

    /**
     * @param CampaignRequestDTO $data
     * @return Campaign
     */
    public function update(CampaignRequestDTO $data): Campaign
    {
        /** @var Campaign $campaign */
        $campaign = $this->model->newQuery()->with('banners')->findOrFail($data->getId());
        $campaign->update($data->toArray());

        return $campaign;
    }

    /**
     * @param CampaignRequestDTO $data
     * @return Campaign
     */
    public function create(CampaignRequestDTO $data): Campaign
    {
        /** @var Campaign $campaign */
        $campaign = $this->model->newQuery()->create($data->toArray());

        return $campaign;
    }

    /**
     * @param Campaign $instance
     * @param array $arrToCreateBanners
     * @return Campaign
     */
    public function createManyBanners(Campaign $instance, array $arrToCreateBanners): Campaign
    {
        $instance->banners()->createMany($arrToCreateBanners);

        return $instance->refresh();
    }
}
