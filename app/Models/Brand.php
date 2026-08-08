<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Brand
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all brands
     */
    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {

        $sql = "
            SELECT
                b.*,
                m.manufacturer_name
            FROM asset_brands b
            INNER JOIN manufacturers m
                ON b.manufacturer_id = m.id
            WHERE
                b.brand_code LIKE :code
                OR b.brand_name LIKE :name
                OR m.manufacturer_name LIKE :manufacturer
            ORDER BY
                b.brand_name ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':code', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':name', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':manufacturer', "%{$search}%", PDO::PARAM_STR);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count Brands
     */
    public function count(string $search = ''): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_brands b
            INNER JOIN manufacturers m
                ON b.manufacturer_id = m.id
            WHERE
                b.brand_code LIKE :code
                OR b.brand_name LIKE :name
                OR m.manufacturer_name LIKE :manufacturer
        ");

        $stmt->bindValue(':code', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':name', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':manufacturer', "%{$search}%", PDO::PARAM_STR);

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Find Brand
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM asset_brands
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create Brand
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO asset_brands
            (
                brand_code,
                brand_name,
                manufacturer_id,
                description,
                status
            )
            VALUES
            (
                ?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['brand_code'],
            $data['brand_name'],
            $data['manufacturer_id'],
            $data['description'],
            $data['status']
        ]);
    }

    /**
     * Update Brand
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE asset_brands
            SET

                brand_code=?,
                brand_name=?,
                manufacturer_id=?,
                description=?,
                status=?

            WHERE id=?
        ");

        return $stmt->execute([
            $data['brand_code'],
            $data['brand_name'],
            $data['manufacturer_id'],
            $data['description'],
            $data['status'],
            $id
        ]);
    }

    /**
     * Deactivate Brand
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE asset_brands
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Brand Code Exists
     */
    public function existsCode(string $code): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_brands
            WHERE brand_code=?
        ");

        $stmt->execute([$code]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * Brand Name Exists
     */
    public function existsName(string $name): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_brands
            WHERE brand_name=?
        ");

        $stmt->execute([$name]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * Manufacturer Dropdown
     */
    public function manufacturerList(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                manufacturer_name
            FROM manufacturers
            WHERE status='Active'
            ORDER BY manufacturer_name
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}