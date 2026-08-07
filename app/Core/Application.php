<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public function run(): void
    {
        Database::connection();

        $router = new Router();

        $router->get('/', [\App\Controllers\HomeController::class, 'index']);

        $router->dispatch(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
    }
}