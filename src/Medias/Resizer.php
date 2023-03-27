<?php

namespace AmphiBee\ThumbnailOnDemand\Medias;

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
    ): array|bool
    {
        $resized = (new $imageResizerClass(
            $id,
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop']
        ))->resize();

        if (!$resized) {
            return false;
        }

        $resizedImage = new ResizedImage(
            $resized['file'],
            $resized['width'],
            $resized['height'],
            $resized['mime-type'],
            $resized['filesize']
        );

        self::$imageMetaData = wp_get_attachment_metadata($id);

        self::$imageMetaData['sizes'][$sizeName] = $resizedImage->getMetaDatas();

        wp_update_attachment_metadata($id, self::$imageMetaData);

        return $resized;
    }
}
