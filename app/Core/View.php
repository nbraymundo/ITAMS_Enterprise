<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        $file = dirname(__DIR__) . "/Views/{$view}.php";

        if (!file_exists($file)) {
            throw new \RuntimeException("View '{$view}' not found.");
        }

        require $file;
    }
}