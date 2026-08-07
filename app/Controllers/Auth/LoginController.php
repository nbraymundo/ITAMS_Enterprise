<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Core\View;

class LoginController extends Controller
{
    public function index(): void
    {
        View::render('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(): void
    {
        echo "Authentication coming next...";
    }

    public function logout(): void
    {
        session_destroy();

        header('Location: /login');

        exit;
    }
}