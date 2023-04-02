<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5d5746e95916214476cb187509d8add5
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Grafika\\' => 8,
        ),
        'A' => 
        array (
            'AmphiBee\\ThumbnailOnDemand\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Grafika\\' => 
        array (
            0 => __DIR__ . '/..' . '/kosinix/grafika/src/Grafika',
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit5d5746e95916214476cb187509d8add5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5d5746e95916214476cb187509d8add5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5d5746e95916214476cb187509d8add5::$classMap;

        }, null, ClassLoader::class);
    }
}
