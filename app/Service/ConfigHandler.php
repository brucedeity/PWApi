<?php

namespace App\Service;

class ConfigHandler
{
    private static $config = array();

    public static function load($file)
    {
        $path = __DIR__ . '/../../config/' . $file . '.php';
        if (file_exists($path)) {
            $config = include $path;
            self::$config = array_merge(self::$config, $config);
        }
    }

    public static function get($key, $default = null)
    {
        return isset(self::$config[$key]) ? self::$config[$key] : $default;
    }
}