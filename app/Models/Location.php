<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Location
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all locations
     */
    public function all(
        string $search = ''
    ): array {

        $sql = "
            SELECT
                l.*,
                b.branch_code,
                b.branch_name,
                c.company_code,
                c.company_name
            FROM locations l

            LEFT JOIN branches b
                ON b.id = l.branch_id

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE
                l.location_code LIKE :search_code

                OR l.location_name LIKE :search_name

                OR l.floor LIKE :search_floor

                OR l.room LIKE :search_room

                OR l.description LIKE :search_description

                OR b.branch_code LIKE :search_branch_code

                OR b.branch_name LIKE :search_branch_name

                OR c.company_code LIKE :search_company_code

                OR c.company_name LIKE :search_company_name

            ORDER BY
                l.location_name ASC
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
            ':search_floor',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_room',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_description',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_branch_code',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':search_branch_name',
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
     * Find location
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                l.*,
                b.branch_code,
                b.branch_name,
                c.company_code,
                c.company_name
            FROM locations l

            LEFT JOIN branches b
                ON b.id = l.branch_id

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE l.id = ?
        ");

        $stmt->execute([
            $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get active branches
     */
    public function branches(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                b.id,
                b.company_id,
                b.branch_code,
                b.branch_name,
                c.company_code,
                c.company_name
            FROM branches b

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE
                b.status = 'Active'

                AND c.status = 'Active'

            ORDER BY
                c.company_name ASC,
                b.branch_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create location
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO locations
            (
                branch_id,
                location_code,
                location_name,
                floor,
                room,
                description,
                status
            )
            VALUES
            (
                ?,?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['branch_id'],
            $data['location_code'],
            $data['location_name'],
            $data['floor'] ?? null,
            $data['room'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update location
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE locations
            SET
                branch_id=?,
                location_code=?,
                location_name=?,
                floor=?,
                room=?,
                description=?,
                status=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['branch_id'],
            $data['location_code'],
            $data['location_name'],
            $data['floor'] ?? null,
            $data['room'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate location
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE locations
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([
            $id
        ]);
    }

    /**
     * Check duplicate location code
     */
    public function existsCode(
        string $code,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM locations
                WHERE location_code = ?
                AND id != ?
            ");

            $stmt->execute([
                $code,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM locations
                WHERE location_code = ?
            ");

            $stmt->execute([
                $code
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check duplicate location name
     */
    public function existsName(
        string $name,
        ?int $excludeId = null
    ): bool {

        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM locations
                WHERE location_name = ?
                AND id != ?
            ");

            $stmt->execute([
                $name,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT COUNT(*)
                FROM locations
                WHERE location_name = ?
            ");

            $stmt->execute([
                $name
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }
}