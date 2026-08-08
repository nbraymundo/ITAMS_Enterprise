<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Asset
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all assets.
     */
    public function all(): array
    {
        $sql = "
            SELECT *
            FROM assets
            ORDER BY id DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count all assets.
     */
    public function count(): int
    {
        $sql = "SELECT COUNT(*) FROM assets";

        return (int) $this->db->query($sql)->fetchColumn();
    }
}