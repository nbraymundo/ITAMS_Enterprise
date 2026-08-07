<?php

declare(strict_types=1);

namespace App\Core;

class Config
{
    public static function get(string $file): array
    {
        $path = dirname(__DIR__, 2) . "/config/{$file}.php";

        if (!file_exists($path)) {
            throw new \RuntimeException("Configuration file '{$file}' not found.");
        }

        return require $path;
    }
}