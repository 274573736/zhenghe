<?php


namespace Composer\Autoload;

class ComposerStatic
{
    public static $prefixLengthsPsr4 = array (
        'M' =>
            array (
                'Mclass\\'  => 7,
                'Model\\'   => 6,
            ),
        'S' => [
            'Server' => 7,
        ],
        'V' =>[
            'Validate' => 9,
        ],
        'l' =>[
            'lib'   => 4,
        ]
    );

    public static $prefixDirsPsr4 = array (
        'Mclass\\' =>
            array (
                0 => __DIR__ . '/..' . '/mclass',
            ),
        'Model\\' =>
            array (
                0 => __DIR__ . '/..' . '/model',
            ),
        'Server\\' =>
            array (
                0 => __DIR__ . '/..' . '/server',
            ),
        'Validate\\' =>
            array (
                0 => __DIR__ . '/..' . '/validate',
            ),
        'lib\\' =>
            array (
                0 => __DIR__ . '/..' . '/library',
            ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStatic::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStatic::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
