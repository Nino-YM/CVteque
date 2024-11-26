<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e1b8ae2d68fe6a5f8a1dad41fb33249
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e1b8ae2d68fe6a5f8a1dad41fb33249::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e1b8ae2d68fe6a5f8a1dad41fb33249::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9e1b8ae2d68fe6a5f8a1dad41fb33249::$classMap;

        }, null, ClassLoader::class);
    }
}