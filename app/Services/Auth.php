<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class Auth
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    /**
     * Authenticate user credentials.
     */
    public function attempt(string $username, string $password): array|false
    {
        $user = $this->users->findByUsername($username);

        if (!$user) {
            return false;
        }

        // Optional: block inactive users
        if (isset($user['status']) && $user['status'] !== 'Active') {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    /**
     * Find user by ID.
     */
    public function user(int $id): array|false
    {
        return $this->users->findById($id);
    }
}