<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Campaign;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdvertisingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return void
     */
    public function testList()
    {
        /** @var Campaign $entity */
        $entity = Campaign::factory()->create();
        Banner::factory()->create(['campaign_id' => $entity->id]);
        Campaign::factory(5)->create();

        $response = $this->getJson('api/v1/campaigns');
        $response->assertJsonStructure(
            [
                'data' => [['id', 'name', 'from', 'to', 'daily_budget', 'total_budget', 'images' => []]],
                'links' => ['first', 'last', 'next', 'prev'],
                'meta' => ['current_page', 'from', 'per_page', 'to'],
            ]
        );
        $response->assertJsonCount(6, 'data');
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->createFileMock(2);

        $response = $this->postJson(
            'api/v1/campaign',
            [
                'name' => 'test name',
                'from' => '1976-08-22',
                'to' => '1977-08-22',
                'daily_budget' => '100.11',
                'total_budget' => '101.34',
                'pictures' => [
                    UploadedFile::fake()->image('image_1.jpg'),
                    UploadedFile::fake()->image('image_2.png'),
                ]]
        );

        /** @var Campaign $campaign */
        $campaign = Campaign::where('name', 'test name')->with('banners')->first();

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertEquals(10011, $campaign->daily_budget);
        $this->assertEquals(10134, $campaign->total_budget);
        $this->assertInstanceOf(Banner::class, $campaign->banners()->first());
        $this->assertEquals(2, $campaign->banners()->count());
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        /** @var Campaign $campaign */
        $campaign = Campaign::factory()->create(['name' => 'test name']);
        /** @var Banner $banner */
        $banner = Banner::factory()->create(['campaign_id' => $campaign->id]);

        $this->createFileMock(1);

        $response = $this->putJson(
            'api/v1/campaign/' . $campaign->id,
            [
                'id' => $campaign->id,
                'name' => 'test name',
                'from' => '1976-08-22',
                'to' => '1977-08-22',
                'daily_budget' => '100.11',
                'total_budget' => '101.34',
                'pictures' => [UploadedFile::fake()->image('image_1.jpg')],
                'imagesToRemove' => ['1' => $banner->id],
            ]
        );

        /** @var Campaign $campaign */
        $campaign = Campaign::where('name', 'test name')->with('banners')->first();
        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertEquals(10011, $campaign->daily_budget);
        $this->assertEquals(10134, $campaign->total_budget);
        $this->assertInstanceOf(Banner::class, $campaign->banners()->first());
        $this->assertEquals(1, $campaign->banners()->count());
        $this->assertNull(Banner::find($banner->id));
        $response->assertSuccessful();
    }

    /**
     * @param int $countImages
     */
    private function createFileMock(int $countImages): void
    {
        $filesystem = $this->createMock(FilesystemAdapter::class);
        $filesystem->expects($this->exactly($countImages))->method('putFileAs')->willReturn(true);
        $filesystemManager = $this->createMock(FilesystemManager::class);
        $filesystemManager->expects($this->once())->method('disk')->willReturn($filesystem);
        app()->instance(FilesystemManager::class, $filesystemManager);
    }
}
