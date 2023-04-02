<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

class ResizedImage
{
    public function __construct(
        protected int $id,
        protected string $file,
        protected string $fileUrl,
        protected int $width,
        protected int $height,
        protected string $mimeType,
        protected int $filesize
    ) {
    }

    public function getMetaData(): array
    {
        return [
            'id' => $this->id,
            'file' => $this->file,
            'fileUrl' => $this->fileUrl,
            'width' => $this->width,
            'height' => $this->height,
            'mimeType' => $this->mimeType,
            'filesize' => $this->filesize,
        ];
    }
}
