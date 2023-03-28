<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

use AmphiBee\ThumbnailOnDemand\Contracts\ImageResizerInterface;

class DefaultImageResizer implements ImageResizerInterface
{
    protected int $id;
    protected int $width;
    protected int $height;
    protected bool $crop;

    public function __construct(int $id, int $width, int $height, bool $crop)
    {
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
    }

    public function resize(): ResizedImage|bool
    {
        $resized = image_make_intermediate_size(
            get_attached_file($this->id),
            $this->width,
            $this->height,
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
