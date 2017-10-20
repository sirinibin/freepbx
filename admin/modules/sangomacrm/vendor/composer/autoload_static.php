<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit263e7012aa1fe66bc5c42adfcda07910
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Ssh' => 
            array (
                0 => __DIR__ . '/..' . '/herzult/php-ssh/src',
            ),
        ),
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
        'O' => 
        array (
            'OAuth\\Unit' => 
            array (
                0 => __DIR__ . '/..' . '/lusitanian/oauth/tests',
            ),
            'OAuth' => 
            array (
                0 => __DIR__ . '/..' . '/lusitanian/oauth/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit263e7012aa1fe66bc5c42adfcda07910::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}