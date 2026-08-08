<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;

class RoleMiddleware
{
    /**
     * Ensure the current user has one of the allowed roles.
     */
    public static function handle(array $allowedRoles): void
    {
        AuthMiddleware::handle();

        $roleId = Session::get('role_id');

        if (!in_array($roleId, $allowedRoles, true)) {

            Response::status(403);

            exit('403 Forbidden');
        }
    }
}