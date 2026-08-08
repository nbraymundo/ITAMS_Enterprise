<?php

declare(strict_types=1);

namespace App\Controllers\Dashboard;

use App\Core\Session;
use App\Core\View;
use App\Middleware\AuthMiddleware;

class DashboardController
{
    public function index(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Authentication Check
        |--------------------------------------------------------------------------
        */

        AuthMiddleware::handle();

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        View::render(
            'dashboard/index',
            [
                'title' => 'Dashboard',
                'user'  => Session::get('auth')
            ]
        );
    }
}