<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Branch
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all branches
     */
    public function all(
        string $search = ''
    ): array {

        $sql = "
            SELECT
                b.*,
                c.company_code,
                c.company_name
            FROM branches b
            LEFT JOIN companies c
                ON c.id = b.company_id
            WHERE
                b.branch_code LIKE :search_code
                OR b.branch_name LIKE :search_name
                OR b.address LIKE :search_address
                OR c.company_code LIKE :search_company_code
                OR c.company_name LIKE :search_company_name
            ORDER BY
                b.branch_name ASC
        ";

        $stmt = $this->db->prepare($sql);

        $searchValue = "%{$search}%";

        $stmt->bindValue(
            ':search_code',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_name',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_address',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_company_code',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_company_name',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find branch
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                b.*,
                c.company_code,
                c.company_name
            FROM branches b
            LEFT JOIN companies c
                ON c.id = b.company_id
            WHERE b.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get active companies
     */
    public function companies(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                company_code,
                company_name
            FROM companies
            WHERE status = 'Active'
            ORDER BY company_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create branch
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO branches
            (
                company_id,
                branch_code,
                branch_name,
                address,
                status
            )
            VALUES
            (
                ?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['company_id'],
            $data['branch_code'],
            $data['branch_name'],
            $data['address'] ?? null,
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update branch
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE branches
            SET
                company_id=?,
                branch_code=?,
                branch_name=?,
                address=?,
                status=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['company_id'],
            $data['branch_code'],
            $data['branch_name'],
            $data['address'] ?? null,
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate branch
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE branches
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Check duplicate branch code
     */
    public function existsCode(
        string $code,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM branches
                WHERE branch_code = ?
                AND id != ?
            ");

            $stmt->execute([
                $code,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM branches
                WHERE branch_code = ?
            ");

            $stmt->execute([
                $code
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check duplicate branch name
     */
    public function existsName(
        string $name,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM branches
                WHERE branch_name = ?
                AND id != ?
            ");

            $stmt->execute([
                $name,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM branches
                WHERE branch_name = ?
            ");

            $stmt->execute([
                $name
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }
}