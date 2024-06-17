<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit37b1ffcd5fa04a7b3ff276e3e1d05629
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
            'Spatie\\TemporaryDirectory\\' => 26,
            'Spatie\\Image\\' => 13,
            'Spatie\\ImageOptimizer\\' => 22,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'L' => 
        array (
            'League\\MimeTypeDetection\\' => 25,
            'League\\Glide\\' => 13,
            'League\\Flysystem\\Local\\' => 23,
            'League\\Flysystem\\' => 17,
        ),
        'I' => 
        array (
            'Intervention\\Image\\' => 19,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
        ),
        'A' => 
        array (
            'AmphiBee\\ThumbnailOnDemand\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Spatie\\TemporaryDirectory\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/temporary-directory/src',
        ),
        'Spatie\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/image/src',
        ),
        'Spatie\\ImageOptimizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/image-optimizer/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
            1 => __DIR__ . '/..' . '/psr/http-factory/src',
        ),
        'League\\MimeTypeDetection\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/mime-type-detection/src',
        ),
        'League\\Glide\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/glide/src',
        ),
        'League\\Flysystem\\Local\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/flysystem-local',
        ),
        'League\\Flysystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/flysystem/src',
        ),
        'Intervention\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/image/src/Intervention/Image',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'AmphiBee\\ThumbnailOnDemand\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit37b1ffcd5fa04a7b3ff276e3e1d05629::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit37b1ffcd5fa04a7b3ff276e3e1d05629::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit37b1ffcd5fa04a7b3ff276e3e1d05629::$classMap;

        }, null, ClassLoader::class);
    }
}
