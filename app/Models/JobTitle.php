<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class JobTitle
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all job titles
     */
    public function all(string $search = ''): array
    {
        $sql = "
            SELECT
                id,
                job_title_code,
                job_title,
                description,
                status,
                created_at,
                updated_at

            FROM job_titles

            WHERE
                job_title_code LIKE :job_title_code
                OR job_title LIKE :job_title
                OR description LIKE :description

            ORDER BY
                job_title ASC
        ";

        $stmt = $this->db->prepare($sql);

        $searchValue = "%{$search}%";

        $stmt->bindValue(
            ':job_title_code',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':job_title',
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
     * Find job title
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                job_title_code,
                job_title,
                description,
                status,
                created_at,
                updated_at

            FROM job_titles

            WHERE id = ?

            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check duplicate job title code
     */
    public function existsCode(
        string $code,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT id
                FROM job_titles

                WHERE job_title_code = ?

                AND id <> ?

                LIMIT 1
            ");

            $stmt->execute([
                $code,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT id
                FROM job_titles

                WHERE job_title_code = ?

                LIMIT 1
            ");

            $stmt->execute([
                $code
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check duplicate job title name
     */
    public function existsName(
        string $jobTitle,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT id
                FROM job_titles

                WHERE job_title = ?

                AND id <> ?

                LIMIT 1
            ");

            $stmt->execute([
                $jobTitle,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT id
                FROM job_titles

                WHERE job_title = ?

                LIMIT 1
            ");

            $stmt->execute([
                $jobTitle
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Get active job titles
     *
     * Used by Employee module dropdown.
     */
    public function active(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                job_title_code,
                job_title

            FROM job_titles

            WHERE status = 'Active'

            ORDER BY
                job_title ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create job title
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO job_titles
            (
                job_title_code,
                job_title,
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
            $data['job_title_code'],
            $data['job_title'],
            $data['description'] ?? null,
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update job title
     */
    public function update(
        int $id,
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE job_titles

            SET
                job_title_code = ?,
                job_title = ?,
                description = ?,
                status = ?

            WHERE id = ?
        ");

        return $stmt->execute([
            $data['job_title_code'],
            $data['job_title'],
            $data['description'] ?? null,
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate job title
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE job_titles

            SET status = 'Inactive'

            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}