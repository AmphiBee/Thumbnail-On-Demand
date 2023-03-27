<?php

namespace AmphiBee\ThumbnailOnDemand\Medias;

use AmphiBee\ThumbnailOnDemand\Contract\ImageResizerInterface;

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

    public function resize(): array|bool
    {
        return image_make_intermediate_size(
            get_attached_file($this->id),
            $this->width,
            $this->height,
            $this->crop
        );
    }
}
