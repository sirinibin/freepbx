<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0add5e43809a9bddbcdc89867cb2a3b5
{
    public static $prefixLengthsPsr4 = array (
        'j' => 
        array (
            'jamesiarmes\\PhpNtlm\\' => 20,
            'jamesiarmes\\PhpEws\\' => 19,
        ),
        'i' => 
        array (
            'it\\thecsea\\simple_caldav_client\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'jamesiarmes\\PhpNtlm\\' => 
        array (
            0 => __DIR__ . '/..' . '/jamesiarmes/php-ntlm/src',
        ),
        'jamesiarmes\\PhpEws\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-ews/php-ews/src',
        ),
        'it\\thecsea\\simple_caldav_client\\' => 
        array (
            0 => __DIR__ . '/..' . '/thecsea/simple-caldav-client/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'Eluceo\\iCal' => 
            array (
                0 => __DIR__ . '/..' . '/eluceo/ical/src',
            ),
        ),
    );

    public static $classMap = array (
        'om\\Freq' => __DIR__ . '/..' . '/om/icalparser/src/Freq.php',
        'om\\IcalParser' => __DIR__ . '/..' . '/om/icalparser/src/IcalParser.php',
        'om\\Recurrence' => __DIR__ . '/..' . '/om/icalparser/src/Recurrence.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0add5e43809a9bddbcdc89867cb2a3b5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0add5e43809a9bddbcdc89867cb2a3b5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit0add5e43809a9bddbcdc89867cb2a3b5::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit0add5e43809a9bddbcdc89867cb2a3b5::$classMap;

        }, null, ClassLoader::class);
    }
}