<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Model
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {

        $sql = "
            SELECT
                am.*,
                b.brand_name,
                m.manufacturer_name

            FROM asset_models am

            INNER JOIN asset_brands b
                ON am.brand_id = b.id

            INNER JOIN manufacturers m
                ON b.manufacturer_id = m.id

            WHERE

                am.model_code LIKE :code
                OR am.model_name LIKE :model
                OR b.brand_name LIKE :brand
                OR m.manufacturer_name LIKE :manufacturer

            ORDER BY
                am.model_name ASC

            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':code', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':model', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':brand', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':manufacturer', "%{$search}%", PDO::PARAM_STR);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(string $search = ''): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)

            FROM asset_models am

            INNER JOIN asset_brands b
                ON am.brand_id = b.id

            INNER JOIN manufacturers m
                ON b.manufacturer_id = m.id

            WHERE

                am.model_code LIKE :code
                OR am.model_name LIKE :model
                OR b.brand_name LIKE :brand
                OR m.manufacturer_name LIKE :manufacturer
        ");

        $stmt->bindValue(':code', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':model', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':brand', "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(':manufacturer', "%{$search}%", PDO::PARAM_STR);

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM asset_models
            WHERE id=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function brands(): array
    {
        return $this->db
            ->query("
                SELECT
                    b.id,
                    b.brand_name,
                    m.manufacturer_name

                FROM asset_brands b

                INNER JOIN manufacturers m
                    ON b.manufacturer_id = m.id

                WHERE b.status='Active'

                ORDER BY
                    m.manufacturer_name,
                    b.brand_name
            ")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO asset_models
            (
                model_code,
                model_name,
                brand_id,
                description,
                status
            )
            VALUES
            (
                ?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['model_code'],
            $data['model_name'],
            $data['brand_id'],
            $data['description'],
            $data['status']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE asset_models
            SET
                model_code=?,
                model_name=?,
                brand_id=?,
                description=?,
                status=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['model_code'],
            $data['model_name'],
            $data['brand_id'],
            $data['description'],
            $data['status'],
            $id
        ]);
    }

    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE asset_models
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    public function existsCode(string $code): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_models
            WHERE model_code=?
        ");

        $stmt->execute([$code]);

        return (bool)$stmt->fetchColumn();
    }

    public function existsName(string $name): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM asset_models
            WHERE model_name=?
        ");

        $stmt->execute([$name]);

        return (bool)$stmt->fetchColumn();
    }
}