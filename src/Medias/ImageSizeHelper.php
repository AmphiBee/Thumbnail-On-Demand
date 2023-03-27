<?php
namespace AmphiBee\ThumbnailOnDemand\Medias;

class ImageSizeHelper
{
    public static function getSizeData(int|string|array $size): array|null
    {
        if (is_array($size)) {
            $sizeData['width'] = $size[0];
            $sizeData['height'] = $size[1];
            $sizeData['crop'] = $size[2] ?? false;
            $sizeName = "{$sizeData['width']}x{$sizeData['height']}" . ($sizeData['crop'] ? '-cropped' : '');
            add_image_size($sizeName, $sizeData['width'], $sizeData['height'], $sizeData['crop']);
        } else {
            $sizeData = wp_get_registered_image_subsizes()[$size] ?? null;
        }

        return $sizeData;
    }
}
