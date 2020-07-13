<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite800f4f7260c87704e20ae90afeefa60
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
        'D' => 
        array (
            'DBC\\' => 4,
        ),
        'A' => 
        array (
            'AUTH\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'DBC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/utils',
        ),
        'AUTH\\' => 
        array (
            0 => __DIR__ . '/../..' . '/utils',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite800f4f7260c87704e20ae90afeefa60::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite800f4f7260c87704e20ae90afeefa60::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}