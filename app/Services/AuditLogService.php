<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Session;
use PDO;

class AuditLogService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Write Audit Log
     */
    public function log(
        string $module,
        string $action,
        ?int $recordId,
        string $description
    ): void {

        $user = Session::get('auth');

        $userId = $user['id'] ?? 0;

        $stmt = $this->db->prepare("
            INSERT INTO audit_logs
            (
                user_id,
                module,
                record_id,
                action,
                description,
                ip_address,
                user_agent,
                created_at
            )
            VALUES
            (
                ?,?,?,?,?,?,?,NOW()
            )
        ");

        $stmt->execute([
            $userId,
            $module,
            $recordId,
            strtoupper($action),
            $description,
            $_SERVER['REMOTE_ADDR'] ?? '',
            substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255)
        ]);
    }

    /**
     * Get Audit Logs
     */
    public function all(
        int $page = 1,
        int $perPage = 20
    ): array {

        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("
            SELECT
                al.*,
                u.full_name
            FROM audit_logs al
            LEFT JOIN users u
                ON u.id = al.user_id
            ORDER BY
                al.created_at DESC
            LIMIT ?
            OFFSET ?
        ");

        $stmt->bindValue(
            1,
            $perPage,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            2,
            $offset,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count Logs
     */
    public function count(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM audit_logs")
            ->fetchColumn();
    }
}