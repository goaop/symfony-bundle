<?php

namespace Symfony\Component\Debug;

class DebugClassLoader
{
    public static $enabled = false;
    public static $invocations = [];

    public static function enable()
    {
        self::$enabled = true;
        self::$invocations[] = 'enable';
    }

    public static function disable()
    {
        self::$enabled = false;
        self::$invocations[] = 'disable';
    }
}
