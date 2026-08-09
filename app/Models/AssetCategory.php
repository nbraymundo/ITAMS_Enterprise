<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class AssetCategory
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function all(
        string $search = '',
        int $page = 1,
        int $perPage = 10,
        string $sort = 'category_name',
        string $direction = 'ASC'
    ): array {
        $allowedSort = [
            'category_code',
            'category_name',
            'description',
            'has_device_specs',
            'status',
            'sort_order'
        ];

        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'category_name';
        }

        $direction = strtoupper($direction);

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'ASC';
        }

        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT
                ac.*,
                (
                    SELECT COUNT(*)
                    FROM assets a
                    WHERE a.category_id = ac.id
                ) AS total_assets
            FROM asset_categories ac
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                WHERE
                    ac.category_code LIKE ?
                    OR ac.category_name LIKE ?
                    OR ac.description LIKE ?
            ";

            $keyword = '%' . $search . '%';

            $params = [
                $keyword,
                $keyword,
                $keyword
            ];
        }

        $sql .= "
            ORDER BY {$sort} {$direction}
            LIMIT ?
            OFFSET ?
        ";

        $params[] = $perPage;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);

        foreach ($params as $i => $value) {
            $stmt->bindValue(
                $i + 1,
                $value,
                is_int($value)
                    ? PDO::PARAM_INT
                    : PDO::PARAM_STR
            );
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll(string $search = ''): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM asset_categories
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                WHERE
                    category_code LIKE ?
                    OR category_name LIKE ?
                    OR description LIKE ?
            ";

            $keyword = '%' . $search . '%';

            $params = [
                $keyword,
                $keyword,
                $keyword
            ];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM asset_categories
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO asset_categories
            (
                category_code,
                category_name,
                description,
                has_device_specs,
                icon,
                color,
                sort_order,
                status
            )
            VALUES
            (
                ?,?,?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['category_code'],
            $data['category_name'],
            $data['description'],
            $data['has_device_specs'],
            $data['icon'],
            $data['color'],
            $data['sort_order'],
            $data['status']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE asset_categories
            SET
                category_code = ?,
                category_name = ?,
                description = ?,
                has_device_specs = ?,
                icon = ?,
                color = ?,
                sort_order = ?,
                status = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['category_code'],
            $data['category_name'],
            $data['description'],
            $data['has_device_specs'],
            $data['icon'],
            $data['color'],
            $data['sort_order'],
            $data['status'],
            $id
        ]);
    }

    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE asset_categories
            SET status = 'Inactive'
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function existsCode(string $code): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_categories
            WHERE category_code = ?
        ");

        $stmt->execute([$code]);

        return (bool) $stmt->fetchColumn();
    }

    public function existsName(string $name): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_categories
            WHERE category_name = ?
        ");

        $stmt->execute([$name]);

        return (bool) $stmt->fetchColumn();
    }

    public function existsCodeExcept(int $id, string $code): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_categories
            WHERE category_code = ?
              AND id <> ?
        ");

        $stmt->execute([
            $code,
            $id
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function existsNameExcept(int $id, string $name): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_categories
            WHERE category_name = ?
              AND id <> ?
        ");

        $stmt->execute([
            $name,
            $id
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function assetCount(int $id): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM assets
            WHERE category_id = ?
        ");

        $stmt->execute([$id]);

        return (int) $stmt->fetchColumn();
    }
}
