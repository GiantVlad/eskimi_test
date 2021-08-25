<?php

namespace Tests\Unit;

use App\DTO\CampaignRequestDTO;
use App\Models\Campaign;
use App\Repositories\BannerRepository;
use App\Repositories\CampaignRepository;
use App\Services\CampaignService;
use Illuminate\Contracts\Pagination\Paginator;
use PHPUnit\Framework\TestCase;

class CampaignServiceTest extends TestCase
{
    /**
     * @var CampaignRepository|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private mixed $campaignRepository;
    /**
     * @var BannerRepository|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private mixed $bannerRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->campaignRepository = $this->createMock(CampaignRepository::class);
        $this->bannerRepository = $this->createMock(BannerRepository::class);
    }

    /**
     * @return void
     */
    public function testGetCampaigns()
    {
        $paginator = $this->createMock(Paginator::class);
        $this->campaignRepository->expects($this->once())
            ->method('getList')
            ->with(15)
            ->willReturn($paginator);
        $service = new CampaignService($this->campaignRepository, $this->bannerRepository);
        $result = $service->getCampaigns();
        $this->assertInstanceOf(Paginator::class, $result);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $requestData = new CampaignRequestDTO([
            'id' => 11,
            'name' => 'name',
            'daily_budget' => 112.23,
            'total_budget' => 1312.24,
            'from' => '1976-08-22',
            'to' => '2021-08-22',
            'pictures' => ['image1', 'image2'],
            'imagesToRemove' => ['3' => 3],
        ]);

        $campaign = new Campaign();

        $this->campaignRepository->expects($this->once())
            ->method('update')
            ->with($requestData)
            ->willReturn($campaign);

        $this->bannerRepository->expects($this->once())->method('removeMany')->with([3]);

        $this->campaignRepository->expects($this->once())
            ->method('createManyBanners')
            ->with($campaign)
            ->willReturn($campaign);

        $service = new CampaignService($this->campaignRepository, $this->bannerRepository);

        $result = $service->update($requestData);
        $this->assertInstanceOf(Campaign::class, $result);
    }

    /**
     * @return void
     */
    public function testUpdateWithoutRemovalImages()
    {
        $requestData = new CampaignRequestDTO([
            'id' => 11,
            'name' => 'name',
            'daily_budget' => 112.23,
            'total_budget' => 1312.24,
            'from' => '1976-08-22',
            'to' => '2021-08-22',
            'pictures' => ['image1', 'image2'],
        ]);

        $campaign = new Campaign();

        $this->campaignRepository->expects($this->once())
            ->method('update')
            ->with($requestData)
            ->willReturn($campaign);

        $this->bannerRepository->expects($this->never())->method('removeMany');

        $this->campaignRepository->expects($this->once())
            ->method('createManyBanners')
            ->with($campaign)
            ->willReturn($campaign);

        $service = new CampaignService($this->campaignRepository, $this->bannerRepository);

        $result = $service->update($requestData);
        $this->assertInstanceOf(Campaign::class, $result);
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $requestData = new CampaignRequestDTO([
            'name' => 'name',
            'daily_budget' => 112.23,
            'total_budget' => 1312.24,
            'from' => '1976-08-22',
            'to' => '2021-08-22',
            'pictures' => ['image1', 'image2'],
        ]);

        $campaign = new Campaign();

        $this->campaignRepository->expects($this->once())
            ->method('create')
            ->with($requestData)
            ->willReturn($campaign);

        $this->campaignRepository->expects($this->once())
            ->method('createManyBanners')
            ->with($campaign)
            ->willReturn($campaign);

        $service = new CampaignService($this->campaignRepository, $this->bannerRepository);

        $result = $service->create($requestData);
        $this->assertInstanceOf(Campaign::class, $result);
    }
}
