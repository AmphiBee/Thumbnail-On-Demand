<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Contracts;

use AmphiBee\ThumbnailOnDemand\Medias\ResizedImage;

interface ImageResizerInterface
{
    public function __construct(int $id, int $width, int $height, bool $crop);
    public function resize(): ResizedImage|bool;
}
