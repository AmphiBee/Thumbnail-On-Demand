<?php

declare(strict_types=1);

namespace AmphiBee\ThumbnailOnDemand\Providers;

use AmphiBee\ThumbnailOnDemand\Facades\ImageSizeHelper;

class ResizerEventHandlers
{
    public function __construct()
    {
        add_filter('intermediate_image_sizes_advanced', fn (array $sizes): array => $this->disableAutoResize($sizes), 10);
        add_filter('image_size_names_choose', fn (array $names): array => self::disableNameChoose($names), 10);
        add_filter('image_downsize', fn ($downsize, int|string $id, int|string|array $size): bool|array => ((int) $id) > 0 ? $this->resizeEvent($downsize, (int) $id, $size) : $downsize, 10, 3);
    }

    public static function disableNameChoose(array $names): array
    {
        return did_action('add_attachment')
            ? ['thumbnail' => __('Thumbnail')]
            : $names;
    }

    public function disableAutoResize(array $sizes): array
    {
        $registeredSizes = array_keys(wp_get_registered_image_subsizes());
        $include = apply_filters('tod/include_thumbnail_sizes', []);
        $exclude = apply_filters('tod/exclude_thumbnail_sizes', $registeredSizes);

        foreach ($exclude as $keySize) {
            if (isset($include[$keySize])) {
                continue;
            }

            if (isset($sizes[$keySize])) {
                unset($sizes[$keySize]);
            }
        }

        return $sizes;
    }

    public function resizeEvent($downsize, int|string $id, int|string|array $size): bool|array
    {
        if ($downsize !== false) {
            return $downsize;
        }

        $sizeData = ImageSizeHelper::getSizeData($size);
        if (! $sizeData) {
            return false;
        }

        return $this->collectImages((int) $id, $size);
    }

    protected function collectImages(int $id, int|string|array $sizeName): bool|array
    {
        if (is_array($sizeName)) {
            $sizeName = implode('x', $sizeName);
        }

        $registeredSizes = wp_get_registered_image_subsizes();
        $sizeData = $registeredSizes[$sizeName];

        $imageResizerClass = (defined('IMAGE_RESIZER_CLASS') && is_subclass_of(IMAGE_RESIZER_CLASS, ImageResizerInterface::class)) ? IMAGE_RESIZER_CLASS : '\\AmphiBee\\ThumbnailOnDemand\\Medias\\SpatieImageResizer';

        $resizer = new Resizer($id);
        $imageMetadata = $resizer->getImageMetadata();

        if (! isset($imageMetadata['sizes'])) {
            $imageMetadata = $resizer->generateMetadatas();
        }

        $sizes = $imageMetadata['sizes'];
        foreach ($registeredSizes as $subName => $subData) {
            if (! isset($sizes[$subName])) {
                $resizer->resize($subName, $subData, $imageResizerClass);
            }
        }

        if (isset($sizes[$sizeName]['fileUrl'])) {
            return [
                $sizes[$sizeName]['fileUrl'],
                $sizes[$sizeName]['width'],
                $sizes[$sizeName]['height'],
                $sizes[$sizeName]['crop'] ?? false,
            ];
        }

        return $resizer->resize($sizeName, $sizeData, $imageResizerClass);
    }
}
