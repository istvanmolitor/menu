<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8728356f60c372943ef5e9e5ca6c26f7
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Molitor\\Menu\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Molitor\\Menu\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit8728356f60c372943ef5e9e5ca6c26f7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8728356f60c372943ef5e9e5ca6c26f7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8728356f60c372943ef5e9e5ca6c26f7::$classMap;

        }, null, ClassLoader::class);
    }
}
