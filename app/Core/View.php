<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'app'
    ): void
    {
        extract($data);

        $viewFile = dirname(__DIR__) . "/Views/{$view}.php";

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View '{$view}' not found.");
        }

        ob_start();

        require $viewFile;

        $content = ob_get_clean();

        $layoutFile = dirname(__DIR__) . "/layouts/{$layout}.php";

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout '{$layout}' not found.");
        }

        require $layoutFile;
    }
}