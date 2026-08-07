<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Core\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function index(): void
    {
        View::render(
            'auth/login',
            [
                'title' => 'Login'
            ],
            'auth'
        );
    }

    /**
     * Authenticate the user.
     * (Implementation will be added in the next sprint.)
     */
    public function authenticate(): void
    {
        echo 'Authentication coming next...';
    }

    /**
     * Logout the current user.
     */
    public function logout(): void
    {
        session_destroy();

        header('Location: /login');

        exit;
    }
}