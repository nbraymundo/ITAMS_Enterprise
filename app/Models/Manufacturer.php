<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Manufacturer
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all manufacturers
     */
    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {

        $sql = "
            SELECT *
            FROM manufacturers
            WHERE
                manufacturer_code LIKE :code
                OR manufacturer_name LIKE :name
                OR country LIKE :country
                OR website LIKE :website
            ORDER BY manufacturer_name ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':code',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':name',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':country',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':website',
            "%{$search}%",
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
     * Count manufacturers
     */
    public function count(string $search = ''): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM manufacturers
            WHERE
                manufacturer_code LIKE :code
                OR manufacturer_name LIKE :name
                OR country LIKE :country
                OR website LIKE :website
        ");

        $stmt->bindValue(
            ':code',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':name',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':country',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':website',
            "%{$search}%",
            PDO::PARAM_STR
        );

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /**
     * Find manufacturer
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM manufacturers
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create manufacturer
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO manufacturers
            (
                manufacturer_code,
                manufacturer_name,
                website,
                contact_person,
                email,
                phone,
                country,
                description,
                status
            )
            VALUES
            (
                ?,?,?,?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $data['manufacturer_code'],
            $data['manufacturer_name'],
            $data['website'],
            $data['contact_person'],
            $data['email'],
            $data['phone'],
            $data['country'],
            $data['description'],
            $data['status']
        ]);
    }

    /**
     * Update manufacturer
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("
            UPDATE manufacturers
            SET
                manufacturer_code=?,
                manufacturer_name=?,
                website=?,
                contact_person=?,
                email=?,
                phone=?,
                country=?,
                description=?,
                status=?
            WHERE id=?
        ");

        return $stmt->execute([
            $data['manufacturer_code'],
            $data['manufacturer_name'],
            $data['website'],
            $data['contact_person'],
            $data['email'],
            $data['phone'],
            $data['country'],
            $data['description'],
            $data['status'],
            $id
        ]);
    }

    /**
     * Deactivate manufacturer
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE manufacturers
            SET status='Inactive'
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Code already exists
     */
    public function existsCode(string $code): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM manufacturers
            WHERE manufacturer_code=?
        ");

        $stmt->execute([$code]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * Name already exists
     */
    public function existsName(string $name): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM manufacturers
            WHERE manufacturer_name=?
        ");

        $stmt->execute([$name]);

        return (bool)$stmt->fetchColumn();
    }
}