<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\Auth;

class LoginController
{
    /**
     * Display Login Page
     */
    public function index(): void
    {
        // Redirect authenticated users
        if (Session::has('user_id')) {
            Response::redirect('/dashboard');
        }

        View::render(
            'auth/login',
            [
                'title'    => 'Sign In',
                'error'    => Session::getFlash('error'),
                'username' => Session::getFlash('old_username')
            ],
            'auth'
        );
    }

    /**
     * Process Login
     */
    public function store(): void
    {
        $request = new Request();

        $username = trim((string) $request->post('username'));
        $password = (string) $request->post('password');

        // Validate input
        if ($username === '' || $password === '') {

            Session::flash(
                'error',
                'Username and password are required.'
            );

            Session::flash(
                'old_username',
                $username
            );

            Response::redirect('/login');
        }

        $auth = new Auth();

        $user = $auth->attempt(
            $username,
            $password
        );

        // Authentication failed
        if ($user === false) {

            Session::flash(
                'error',
                'Invalid username or password.'
            );

            Session::flash(
                'old_username',
                $username
            );

            Response::redirect('/login');
        }

        // Prevent Session Fixation
        Session::regenerate();

        // Store authenticated user
        Session::set('auth', [
            'id'       => $user['id'],
            'username' => $user['username'],
            'role_id'  => $user['role_id'] ?? null,
        ]);

        // Compatibility session keys
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('role_id', $user['role_id'] ?? null);

        // Redirect to Dashboard
        Response::redirect('/dashboard');
    }

    /**
     * Logout User
     * (AUTH-02)
     */
    public function logout(): void
    {
        Session::destroy();

        Response::redirect('/login');
    }
}