<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public function run(): void
{
    Database::connection();

    $request = new Request();

    $router = new Router();

    $router->get(
        '/',
        [\App\Controllers\HomeController::class, 'index']
    );

    $router->dispatch($request);
}
}