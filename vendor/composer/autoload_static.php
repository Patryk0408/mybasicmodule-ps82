<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit046e4a77864754d5baa4c459b377f456
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyBasicModule\\Form\\' => 19,
            'MyBasicModule\\Entity\\' => 21,
            'MyBasicModule\\Controller\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyBasicModule\\Form\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Form',
        ),
        'MyBasicModule\\Entity\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Entity',
        ),
        'MyBasicModule\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/controller',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit046e4a77864754d5baa4c459b377f456::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit046e4a77864754d5baa4c459b377f456::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit046e4a77864754d5baa4c459b377f456::$classMap;

        }, null, ClassLoader::class);
    }
}
