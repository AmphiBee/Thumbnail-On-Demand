<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Contracts;

use AmphiBee\ThumbnailOnDemand\Medias\ResizedImage;

interface ImageResizerInterface
{
    public function resize(): ResizedImage|bool;
}
