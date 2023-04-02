<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

class DefaultImageResizer extends AbstractImageResizer
{
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
        //
    }

    public function resize(): ResizedImage|bool
    {
        $resized = image_make_intermediate_size(
            $this->imageFile,
            $this->maxWidth,
            $this->maxHeight,
            $this->crop
        );

        if (false === $resized) {
            return false;
        }

        return new ResizedImage(
            $this->id,
            $resized['file'],
            dirname(wp_get_attachment_url($this->id)) . '/' . $resized['file'],
            $resized['width'],
            $resized['height'],
            $resized['mime-type'],
            $resized['filesize']
        );
    }
}
