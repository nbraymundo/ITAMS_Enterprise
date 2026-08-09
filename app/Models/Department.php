<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Department
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all departments
     */
    public function all(string $search = ''): array
    {
        $sql = "
            SELECT
                id,
                department_code,
                department_name,
                description,
                status,
                created_at,
                updated_at

            FROM departments

            WHERE
                department_code LIKE :department_code

                OR department_name LIKE :department_name

                OR description LIKE :description

            ORDER BY
                department_name ASC
        ";

        $stmt = $this->db->prepare($sql);

        $searchValue = "%{$search}%";

        $stmt->bindValue(
            ':department_code',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':department_name',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':description',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find department
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                department_code,
                department_name,
                description,
                status,
                created_at,
                updated_at

            FROM departments

            WHERE id = ?

            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check whether department code already exists
     */
    public function existsCode(
        string $departmentCode,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT id

                FROM departments

                WHERE department_code = ?

                AND id <> ?

                LIMIT 1
            ");

            $stmt->execute([
                $departmentCode,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT id

                FROM departments

                WHERE department_code = ?

                LIMIT 1
            ");

            $stmt->execute([
                $departmentCode
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check whether department name already exists
     */
    public function existsName(
        string $departmentName,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT id

                FROM departments

                WHERE department_name = ?

                AND id <> ?

                LIMIT 1
            ");

            $stmt->execute([
                $departmentName,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT id

                FROM departments

                WHERE department_name = ?

                LIMIT 1
            ");

            $stmt->execute([
                $departmentName
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Get active departments
     *
     * Used by Employee and other modules.
     */
    public function active(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                department_code,
                department_name

            FROM departments

            WHERE status = 'Active'

            ORDER BY department_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create department
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO departments
            (
                department_code,
                department_name,
                description,
                status
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?
            )
        ");

        return $stmt->execute([
            $data['department_code'],
            $data['department_name'],
            $data['description'] ?? null,
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update department
     */
    public function update(
        int $id,
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE departments

            SET
                department_code = ?,
                department_name = ?,
                description = ?,
                status = ?

            WHERE id = ?
        ");

        return $stmt->execute([
            $data['department_code'],
            $data['department_name'],
            $data['description'] ?? null,
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate department
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE departments

            SET status = 'Inactive'

            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}