<?php

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function ($class) {
            $baseDir = dirname(__DIR__);
            $paths = [
                $baseDir . '/app/controllers/' . $class . '.php',
                $baseDir . '/app/controllers/admin/' . $class . '.php',
                $baseDir . '/app/models/' . $class . '.php',
                $baseDir . '/core/' . $class . '.php',
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    require_once $path;
                    return;
                }
            }
        });
    }
}

