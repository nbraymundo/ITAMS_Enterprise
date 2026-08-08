<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;

class AuthMiddleware
{
    /**
     * Ensure the user is authenticated.
     */
    public static function handle(): void
    {
        if (!Session::has('user_id')) {
            Response::redirect('/login');
        }
    }
}