<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitefb12b817e5ab931a57b20dab7b32485
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '2a3c2110e8e0295330dc3d11a4cbc4cb' => __DIR__ . '/..' . '/php-webdriver/webdriver/lib/Exception/TimeoutException.php',
    );

    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'duzun\\' => 6,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Process\\' => 26,
        ),
        'R' => 
        array (
            'React\\EventLoop\\' => 16,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'F' => 
        array (
            'Facebook\\WebDriver\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'duzun\\' => 
        array (
            0 => __DIR__ . '/..' . '/duzun/hquery/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'React\\EventLoop\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/event-loop/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Facebook\\WebDriver\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-webdriver/webdriver/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'h' => 
        array (
            'hQuery' => 
            array (
                0 => __DIR__ . '/..' . '/duzun/hquery/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitefb12b817e5ab931a57b20dab7b32485::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitefb12b817e5ab931a57b20dab7b32485::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitefb12b817e5ab931a57b20dab7b32485::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitefb12b817e5ab931a57b20dab7b32485::$classMap;

        }, null, ClassLoader::class);
    }
}
