<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ImageUploadException;
use Illuminate\Filesystem\FilesystemManager;
use Psr\Log\LoggerInterface;

class BannerService
{
    public function __construct(
        private FilesystemManager $filesystemManager,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @param array $images
     * @return string[]
     * @throws ImageUploadException
     */
    public function uploadImages(array $images): array
    {
        $imageNames = [];
        $disk = $this->filesystemManager->disk('public_banners');
        try {
            foreach ($images as $image) {
                $imageName = $this->generateImageName($image->extension());

                $disk->putFileAs('', $image, $imageName);

                $imageNames[] = $imageName;
            }
        } catch (\Throwable $exception) {
            $this->logger->error("An error occurred while uploading the image.", ['exception' => $exception]);

            throw new ImageUploadException($exception->getMessage(), $exception->getCode());
        }

        return $imageNames;
    }

    /**
     * @param string $extension
     * @return string
     * @throws \Exception
     */
    private function generateImageName(string $extension): string
    {
        return 'image_' . \time() . \random_int(100, 999) . '.' . $extension;
    }
}
