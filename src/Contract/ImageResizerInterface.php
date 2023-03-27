<?php
namespace AmphiBee\ThumbnailOnDemand\Contract;

interface ImageResizerInterface
{
    public function __construct(int $id, int $width, int $height, bool $crop);
    public function resize(): array|bool;
}
