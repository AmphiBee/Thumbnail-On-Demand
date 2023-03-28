<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Medias;

class ResizedImage
{
    protected int $id;
    protected string $file;
    protected string $fileUrl;
    protected int $width;
    protected int $height;
    protected string $mimeType;
    protected int $filesize;

    /**
     * @return array
     */
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

    public function __construct(int $id, string $file, string $fileUrl, int $width, int $height, string $mimeType, int $filesize)
    {
        $this->id = $id;
        $this->file = $file;
        $this->fileUrl = $fileUrl;
        $this->width = $width;
        $this->height = $height;
        $this->mimeType = $mimeType;
        $this->filesize = $filesize;
    }
}
