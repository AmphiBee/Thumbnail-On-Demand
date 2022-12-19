<?php

namespace AmphiBee\ThumbnailOnDemand\Medias;

/**
 * Class Resizer
 */
class Resizer
{
    /**
     * @var array|bool
     */
    protected static array|bool $imageMetaData;

    public function __construct()
    {
        add_filter('intermediate_image_sizes_advanced', [$this, 'disableAutoResize'], 10);
        add_filter('image_size_names_choose', [$this, 'disableNameChoose'], 10);
        add_filter('image_downsize', [$this, 'resizeEvent'], 10, 3);
    }

    /**
     * Prevents the function `wp_prepare_attachment_for_js` from creating all sizes during upload
     *
     * @param  array  $names Array of image size labels keyed by their name. Default values include 'Thumbnail', 'Medium', 'Large', and 'Full Size'.
     * @return array
     */
    public static function disableNameChoose(array $names): array
    {
        return did_action('add_attachment')
            ? ['thumbnail' => __('Thumbnail')]
            : $names;
    }

    /**
     * Remove every thumbnail sizes by default.
     *
     * @param  array  $sizes Associative array of image sizes to be created.
     * @return array
     */
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

    /**
     * Process the image downsizes only if needed.
     *
     * @param $downsize Whether to short-circuit the image downsize.
     * @param  int  $id Attachment ID for image.
     * @param  int|string|array  $size Requested image size. Can be any registered image size name, or an array of width and height values in pixels (in that order).
     * @return array|false
     */
    public function resizeEvent($downsize, int $id, int|string|array $size): bool|array
    {
        // if a previous filter has already managed the thumbnail, don't do anything
        if (false !== $downsize) {
            return $downsize;
        }

        // if is array, it's a custom size we need to declare.
        if (is_array($size)) {
            $sizeData['width'] = $size[0];
            $sizeData['height'] = $size[1];
            $sizeData['crop'] = $size[2] ?? false;
            $size = "{$sizeData['width']}x{$sizeData['height']}".($sizeData['crop'] ? '-cropped' : '');
            add_image_size($size, $sizeData['width'], $sizeData['height'], $sizeData['crop']);
        } else {
            $sizeData = wp_get_registered_image_subsizes()[$size] ?? null;
        }

        // if not registered, skip the thumbnail size
        if (! $sizeData) {
            return false;
        }

        self::$imageMetaData = wp_get_attachment_metadata($id);

        $imagePath = get_attached_file($id);

        if (is_array(self::$imageMetaData) && isset(self::$imageMetaData['sizes'][$size])) {
            if (! file_exists($imagePath)) {
                return $this->collectImages($id, $size);
            }

            return false;
        }

        // if not a valid media, skip it
        if (false === self::$imageMetaData) {
            return false;
        }

        $dim = image_resize_dimensions(
            intval(self::$imageMetaData['width']),
            intval(self::$imageMetaData['height']),
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop']
        );

        if (! $dim || $dim[6] < $dim[4] || $dim[7] < $dim[5]) {
            return false;
        }

        return $this->collectImages($id, $size);
    }

    /**
     * Image resizing process
     *
     * @param  int  $id ID of the image to resize
     * @param  string  $sizeName Image size slug
     * @return array|false
     */
    protected function collectImages(int $id, string $sizeName): bool|array
    {
        $registeredSizes = wp_get_registered_image_subsizes();
        $sizeData = $registeredSizes[$sizeName];

        // Create the "srcset" by searching for high-res sizes
        $highResolutionPattern = '/^'.preg_quote($sizeName, '/').'@[1-9]+(\\.[0-9]+)?x$/';
        foreach ($registeredSizes as $subName => $subData) {
            if (! isset(self::$imageMetaData['sizes'][$subName]) && preg_match($highResolutionPattern, $subName)) {
                $this->resize($id, $subName, $subData);
            }
        }

        // resize the main thumbnail requested
        return $this->resize($id, $sizeName, $sizeData);
    }

    /**
     * Resizing process for unique image
     *
     * @param  int  $id ID of the image to resize
     * @param  string  $sizeName Image size slug
     * @param  array  $sizeData Image size metadatas
     * @return array|false
     */
    protected function resize(int $id, string $sizeName, array $sizeData)
    {
        // create the thumb
        $resized = image_make_intermediate_size(
            get_attached_file($id),
            $sizeData['width'],
            $sizeData['height'],
            $sizeData['crop']
        );

        if (! $resized) {
            return false;
        }

        // saving the image metadatas
        self::$imageMetaData['sizes'][$sizeName] = $resized;
        wp_update_attachment_metadata($id, self::$imageMetaData);

        return [
            dirname(wp_get_attachment_url($id)).'/'.$resized['file'],
            $resized['width'],
            $resized['height'],
            true,
        ];
    }
}
