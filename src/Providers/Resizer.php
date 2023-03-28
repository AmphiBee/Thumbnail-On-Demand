<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Providers;

use AmphiBee\ThumbnailOnDemand\Contract\ImageResizerInterface;

class Resizer
{
    protected static array|bool $imageMetaData = [];

    public static function getImageMetadata(): array
    {
        return self::$imageMetaData;
    }

    public static function resize(
        int    $id,
        string $sizeName,
        array  $sizeData,
        string $imageResizerClass
    ): array|bool {
        $resizedImage = (new $imageResizerClass(
            $id,
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop']
        ))->resize();

        if (false === $resizedImage) {
            return false;
        }


        self::$imageMetaData = wp_get_attachment_metadata($id);
        $resizedImageMetaData = $resizedImage->getMetaData();

        self::$imageMetaData['sizes'][$sizeName] = array_intersect_key($resizedImageMetaData, [
            'file' => true,
            'width' => true,
            'height' => true,
            'crop' => true,
        ]);

        wp_update_attachment_metadata($id, self::$imageMetaData);

        return [
            $resizedImageMetaData['fileUrl'],
            $resizedImageMetaData['width'],
            $resizedImageMetaData['height'],
            true
        ];
    }
}
