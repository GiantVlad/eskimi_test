<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CampaignRequestDTO;
use App\Models\Campaign;
use App\Repositories\BannerRepository;
use App\Repositories\CampaignRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class CampaignService
{
    public function __construct(
        private CampaignRepository $campaignRepository,
        private BannerRepository $bannerRepository,
    ) {
    }

    /**
     * @return Paginator
     */
    public function getCampaigns(): Paginator
    {
        return $this->campaignRepository->getList();
    }

    /**
     * @param CampaignRequestDTO $data
     * @return Campaign
     */
    public function update(CampaignRequestDTO $data): Campaign
    {
        $campaign = $this->campaignRepository->update($data);

        if (!empty($data->getImagesToRemove())) {
            $this->bannerRepository->removeMany($data->getImagesToRemove());
        }

        $arrToCreateBanners = $this->prepareArrayToCreateBanners($data->getPictures());

        return $this->campaignRepository->createManyBanners($campaign, $arrToCreateBanners);
    }

    /**
     * @param CampaignRequestDTO $data
     * @return Campaign
     */
    public function create(CampaignRequestDTO $data): Campaign
    {
        $campaign = $this->campaignRepository->create($data);

        $arrToCreateBanners = $this->prepareArrayToCreateBanners($data->getPictures());

        return $this->campaignRepository->createManyBanners($campaign, $arrToCreateBanners);
    }

    /**
     * @param array $pictures
     * @return array
     */
    private function prepareArrayToCreateBanners(array $pictures): array
    {
        $arrToCreateBanners = [];
        foreach ($pictures as $picture) {
            $arrToCreateBanners[] = ['image_name' => $picture];
        }

        return $arrToCreateBanners;
    }
}
