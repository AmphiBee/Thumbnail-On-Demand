<?php
declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

use AmphiBee\ThumbnailOnDemand\Contracts\ImageResizerInterface;

abstract class AbstractImageResizer implements ImageResizerInterface
{
    protected function fallbackResize(
        int $id,
        string $imageFile,
        int $maxWidth,
        int $maxHeight,
        bool $crop,
        int $resizedWidth,
        int $resizedHeight,
        array $imageMetadatas
    ): ResizedImage|bool {
        return (new DefaultImageResizer(
            $id,
            $imageFile,
            $maxWidth,
            $maxHeight,
            $crop,
            $resizedWidth,
            $resizedHeight,
            $imageMetadatas,
        ))->resize();
    }
}
