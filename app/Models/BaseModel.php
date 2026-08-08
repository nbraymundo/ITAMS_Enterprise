<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

abstract class BaseModel
{
    protected PDO $db;

    protected string $table;

    protected string $primaryKey = 'id';

    protected array $fillable = [];

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all records
     */
    public function all(
        string $orderBy = 'id',
        string $direction = 'ASC'
    ): array {

        $stmt = $this->db->query("
            SELECT *
            FROM {$this->table}
            ORDER BY {$orderBy} {$direction}
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find by ID
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE {$this->primaryKey}=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert
     */
    public function create(array $data): bool
    {
        $fields = [];
        $placeholders = [];
        $values = [];

        foreach ($this->fillable as $field) {

            if (array_key_exists($field, $data)) {

                $fields[] = $field;
                $placeholders[] = '?';
                $values[] = $data[$field];
            }
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(',', $fields),
            implode(',', $placeholders)
        );

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    /**
     * Update
     */
    public function update(int $id, array $data): bool
    {
        $sets = [];
        $values = [];

        foreach ($this->fillable as $field) {

            if (array_key_exists($field, $data)) {

                $sets[] = "{$field}=?";
                $values[] = $data[$field];
            }
        }

        $values[] = $id;

        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s=?",
            $this->table,
            implode(',', $sets),
            $this->primaryKey
        );

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    /**
     * Delete
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE
            FROM {$this->table}
            WHERE {$this->primaryKey}=?
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Count
     */
    public function count(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM {$this->table}")
            ->fetchColumn();
    }
}