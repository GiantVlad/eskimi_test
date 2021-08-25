<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\ImageUploadException;
use App\Services\BannerService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class BannerServiceTest extends TestCase
{
    /**
     * @return void
     * @throws ImageUploadException
     */
    public function testUploadImages()
    {
        $image1 = $this->createMock(UploadedFile::class);
        $image1->expects($this->once())->method('extension')->willReturn('jpg');
        $image2 = $this->createMock(UploadedFile::class);
        $image2->expects($this->once())->method('extension')->willReturn('png');
        $images = [$image1, $image2];

        $filesystem = $this->createMock(FilesystemAdapter::class);
        $filesystem->expects($this->exactly(2))
            ->method('putFileAs');

        $filesystemManager = $this->createMock(FilesystemManager::class);
        $filesystemManager->expects($this->once())
            ->method('disk')
            ->with('public_banners')
            ->willReturn($filesystem);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('error');

        $service = new BannerService($filesystemManager, $logger);

        $images = $service->uploadImages($images);
        $this->assertTrue(str_starts_with($images[0], 'image_'));
        $this->assertTrue(str_ends_with($images[1], '.png'));
    }

    /**
     * @return void
     * @throws ImageUploadException
     */
    public function testUploadImagesWithException()
    {
        $this->expectException(ImageUploadException::class);
        $image1 = $this->createMock(UploadedFile::class);
        $image1->expects($this->once())->method('extension')->willReturn('jpg');
        $image2 = $this->createMock(UploadedFile::class);
        $image2->expects($this->never())->method('extension');
        $images = [$image1, $image2];

        $filesystem = $this->createMock(FilesystemAdapter::class);
        $filesystem->expects($this->once())
            ->method('putFileAs')->willThrowException(new \Exception('error', 500));

        $filesystemManager = $this->createMock(FilesystemManager::class);
        $filesystemManager->expects($this->once())
            ->method('disk')
            ->with('public_banners')
            ->willReturn($filesystem);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('error');

        $service = new BannerService($filesystemManager, $logger);

        $service->uploadImages($images);
    }
}
