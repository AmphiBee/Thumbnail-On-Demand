<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Providers;

class Resizer
{
    protected $file;

    protected $metadatas;

    public function __construct(protected int|string|array $id)
    {
    }

    public function getImageMetadata(): bool|array
    {
        return wp_get_attachment_metadata($this->id);
    }

    public function generateMetadatas()
    {
        $this->file = get_attached_file($this->id);
        $this->metadatas = wp_generate_attachment_metadata($this->id, $this->file);
        wp_update_attachment_metadata($this->id, $this->metadatas);

        return $this->metadatas;
    }

    public function resize(
        string $sizeName,
        array $sizeData,
        string $imageResizerClass
    ): array|bool {
        $imageMetaData = $this->metadatas ?: $this->getImageMetadata();

        $dims = image_resize_dimensions(
            $imageMetaData['width'],
            $imageMetaData['height'],
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop']
        );

        $finalDims = [
            'width' => $dims ? $dims[4] : $sizeData['width'],
            'height' => $dims ? $dims[5] : $sizeData['height'],
        ];

        $imageFile = $this->file ?: get_attached_file($this->id);

        if (! file_exists($imageFile)) {
            return false;
        }

        $resizedImage = (new $imageResizerClass(
            $this->id,
            $imageFile,
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop'],
            $finalDims['width'],
            $finalDims['height'],
            $imageMetaData
        ))->resize();

        if ($resizedImage === false) {
            return false;
        }

        $resizedImageMetaData = $resizedImage->getMetaData();

        $imageMetaData['sizes'][$sizeName] = array_merge(
            array_intersect_key($resizedImageMetaData, array_flip(['file', 'width', 'height'])),
            ['fileUrl' => $resizedImageMetaData['fileUrl']]
        );

        wp_update_attachment_metadata($this->id, $imageMetaData);

        return [
            $resizedImageMetaData['fileUrl'],
            $resizedImageMetaData['width'],
            $resizedImageMetaData['height'],
            true,
        ];
    }
}
