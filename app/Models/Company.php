<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Company
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all companies
     */
    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {

        $sql = "
            SELECT *
            FROM companies
            WHERE
                company_code LIKE :search_code
                OR company_name LIKE :search_name
                OR address LIKE :search_address
                OR telephone LIKE :search_telephone
                OR email LIKE :search_email
            ORDER BY company_name ASC
            LIMIT :limit OFFSET :offset
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
            ':search_telephone',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_email',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count companies
     */
    public function count(string $search = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM companies
            WHERE
                company_code LIKE :search_code
                OR company_name LIKE :search_name
                OR address LIKE :search_address
                OR telephone LIKE :search_telephone
                OR email LIKE :search_email
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
            ':search_telephone',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_email',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * Find company
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM companies
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create company
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO companies
            (
                company_code,
                company_name,
                address,
                telephone,
                email,
                status
            )
            VALUES
            (
                ?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['company_code'],
            $data['company_name'],
            $data['address'] ?? null,
            $data['telephone'] ?? null,
            $data['email'] ?? null,
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update company
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE companies
            SET
                company_code=?,
                company_name=?,
                address=?,
                telephone=?,
                email=?,
                status=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['company_code'],
            $data['company_name'],
            $data['address'] ?? null,
            $data['telephone'] ?? null,
            $data['email'] ?? null,
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate company
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE companies
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Check duplicate company code
     */
    public function existsCode(
        string $code,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM companies
                WHERE company_code = ?
                AND id != ?
            ");

            $stmt->execute([
                $code,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM companies
                WHERE company_code = ?
            ");

            $stmt->execute([
                $code
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check duplicate company name
     */
    public function existsName(
        string $name,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM companies
                WHERE company_name = ?
                AND id != ?
            ");

            $stmt->execute([
                $name,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM companies
                WHERE company_name = ?
            ");

            $stmt->execute([
                $name
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }
}