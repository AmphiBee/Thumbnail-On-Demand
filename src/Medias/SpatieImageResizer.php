<?php
declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class SpatieImageResizer extends AbstractImageResizer
{
    protected $editor;
    protected string $imageDriver;

    public function __construct(
        protected int $id,
        protected string $imageFile,
        protected int $maxWidth,
        protected int $maxHeight,
        protected bool $crop,
        protected int $resizedWidth,
        protected int $resizedHeight,
        protected array $imageMetadatas
    ) {
        $this->imageDriver = $this->chooseImageDriver();
    }

    public function resize(): ResizedImage|bool
    {
        try {
            $imageFolder = dirname($this->imageFile);
            $imageFileSuffix = "-{$this->maxWidth}x{$this->maxHeight}".($this->crop ? '-cropped' : '');

            $image = Image::load($this->imageFile)->useImageDriver($this->imageDriver);
            if ($this->crop) {
                $image->crop(Manipulations::CROP_CENTER, $this->resizedWidth, $this->resizedHeight);
            } else {
                $image->width($this->resizedWidth)->height($this->resizedHeight);
            }

            $imageFilenameParts = pathinfo($this->imageFile);
            $imageFilename = $imageFilenameParts['filename'].$imageFileSuffix.'.'.$imageFilenameParts['extension'];
            $imagePath = $imageFolder.DIRECTORY_SEPARATOR.$imageFilename;

            $image->save($imagePath);

            $thumbnail = Image::load($imagePath)->useImageDriver($this->imageDriver);

            return new ResizedImage(
                $this->id,
                $imageFilename,
                dirname(wp_get_attachment_url($this->id)).'/'.$imageFilename,
                intval($thumbnail->getWidth()),
                intval($thumbnail->getHeight()),
                mime_content_type($imagePath),
                filesize($imagePath)
            );
        } catch (\Exception $e) {
            return false;
        }
    }

    private function guessType(string $imageFile): string
    {
        $type = getimagesize($imageFile)[2];

        return match ($type) {
            1 => ImageType::GIF,
            2 => ImageType::JPEG,
            3 => ImageType::PNG,
            15 => ImageType::WBMP,
            default => '',
        };
    }

    private function chooseImageDriver(): string
    {
        if (extension_loaded('imagick')) {
            return 'imagick';
        } elseif (extension_loaded('gd')) {
            return 'gd';
        } else {
            throw new \Exception('No suitable image driver available (Imagick or GD)');
        }
    }
}
