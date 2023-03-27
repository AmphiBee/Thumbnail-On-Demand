<?php
namespace AmphiBee\ThumbnailOnDemand\Medias;

class ResizedImage
{
    protected string $file;
    protected int $width;
    protected int $height;
    protected string $mimeType;
    protected int $filesize;

    /**
     * @return array
     */
    public function getMetaDatas()
    {
        return [
            'file' => $this->file,
            'width' => $this->width,
            'height' => $this->height,
            'mimeType' => $this->mimeType,
            'filesize' => $this->filesize,
        ];
    }

    public function __construct(string $file, int $width, int $height, string $mimeType, int $filesize)
    {
        $this->file = $file;
        $this->width = $width;
        $this->height = $height;
        $this->mimeType = $mimeType;
        $this->filesize = $filesize;
    }
}
