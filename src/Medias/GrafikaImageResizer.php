<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

use Grafika\Grafika;
use Grafika\ImageType;

class GrafikaImageResizer extends AbstractImageResizer
{
    protected $editor;

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
        $this->editor = Grafika::createEditor();
    }

    public function resize(): ResizedImage|bool
    {
        try {
            $imageType = $this->guessType($this->imageFile);
            if ($imageType === '') {
                return $this->fallbackResize(
                    $this->id, $this->imageFile, $this->maxWidth, $this->maxHeight, $this->crop,
                    $this->resizedWidth, $this->resizedHeight, $this->imageMetadatas
                );
            }

            $this->editor->open($resized, $this->imageFile);
            $imageFolder = dirname($this->imageFile);
            $imageFileSuffix = "-{$this->maxWidth}x{$this->maxHeight}" . ($this->crop ? '-cropped' : '');

            if ($this->crop) {
                $this->editor->crop($resized, $this->resizedWidth, $this->resizedHeight, 'smart');
            } elseif ($this->resizedHeight === 0) {
                $this->editor->resizeExactWidth($resized, $this->resizedWidth);
            } elseif ($this->resizedWidth === 0) {
                $this->editor->resizeExactHeight($resized, $this->resizedHeight);
            } else {
                $this->editor->resize($resized, $this->resizedWidth, $this->resizedHeight);
            }

            $imageFilenameParts = pathinfo($this->imageFile);
            $imageFilename = $imageFilenameParts['filename'] . $imageFileSuffix . '.' . $imageFilenameParts['extension'];
            $imagePath = $imageFolder . DIRECTORY_SEPARATOR . $imageFilename;

            $this->editor->save($resized, $imagePath);

            return new ResizedImage(
                $this->id,
                $imageFilename,
                dirname(wp_get_attachment_url($this->id)) . '/' . $imageFilename,
                intval($resized->getWidth()),
                intval($resized->getHeight()),
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
}
