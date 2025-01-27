<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64a8d48fe692b61c2e29ac9b5b1c3a9c
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VSTR\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VSTR\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64a8d48fe692b61c2e29ac9b5b1c3a9c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64a8d48fe692b61c2e29ac9b5b1c3a9c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64a8d48fe692b61c2e29ac9b5b1c3a9c::$classMap;

        }, null, ClassLoader::class);
    }
}
