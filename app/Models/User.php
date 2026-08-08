<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Find user by username.
     */
    public function findByUsername(string $username): array|false
    {
        $sql = "
            SELECT *
            FROM users
            WHERE username = :username
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'username' => $username
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by ID.
     */
    public function findById(int $id): array|false
    {
        $sql = "
            SELECT *
            FROM users
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}