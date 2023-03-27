<?php
namespace AmphiBee\ThumbnailOnDemand\Medias;

class ResizerEventHandlers
{
    public function __construct()
    {
        add_filter('intermediate_image_sizes_advanced', [$this, 'disableAutoResize'], 10);
        add_filter('image_size_names_choose', [$this, 'disableNameChoose'], 10);
        add_filter('image_downsize', [$this, 'resizeEvent'], 10, 3);
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

    public function resizeEvent($downsize, int $id, int|string|array $size): bool|array
    {
        if (false !== $downsize) {
            return $downsize;
        }

        $sizeData = ImageSizeHelper::getSizeData($size);
        if (! $sizeData) {
            return false;
        }

        return $this->collectImages($id, $size);
    }

    protected function collectImages(int $id, string $sizeName): bool|array
    {
        $registeredSizes = wp_get_registered_image_subsizes();
        $sizeData = $registeredSizes[$sizeName];

        // Create the "srcset" by searching for high-res sizes
        $highResolutionPattern = '/^'.preg_quote($sizeName, '/').'@[1-9]+(\\.[0-9]+)?x$/';

        $imageResizerClass = (defined('IMAGE_RESIZER_CLASS') && is_subclass_of(IMAGE_RESIZER_CLASS, ImageResizerInterface::class)) ? IMAGE_RESIZER_CLASS : '\\AmphiBee\\ThumbnailOnDemand\\Medias\\DefaultImageResizer';

        foreach ($registeredSizes as $subName => $subData) {
            if (! isset(Resizer::getImageMetadata()['sizes'][$subName]) && preg_match($highResolutionPattern, $subName)) {
                Resizer::resize($id, $subName, $subData, $imageResizerClass);
            }
        }

        // resize the main thumbnail requested
        return Resizer::resize($id, $sizeName, $sizeData, $imageResizerClass);
    }
}
