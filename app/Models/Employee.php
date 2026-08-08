<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Employee
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all employees
     */
    public function all(string $search = ''): array
    {
        $sql = "
            SELECT
                e.*,

                jt.job_title,

                d.department_name,

                l.location_code,
                l.location_name,

                b.branch_code,
                b.branch_name,

                c.company_code,
                c.company_name

            FROM employees e

            LEFT JOIN job_titles jt
                ON jt.id = e.job_title_id

            LEFT JOIN departments d
                ON d.id = e.department_id

            LEFT JOIN locations l
                ON l.id = e.location_id

            LEFT JOIN branches b
                ON b.id = l.branch_id

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE
                e.employee_no LIKE :employee_no
                OR e.first_name LIKE :first_name
                OR e.last_name LIKE :last_name
                OR e.email LIKE :email
                OR jt.job_title LIKE :job_title
                OR d.department_name LIKE :department
                OR l.location_name LIKE :location
                OR b.branch_name LIKE :branch
                OR c.company_name LIKE :company

            ORDER BY
                e.last_name ASC,
                e.first_name ASC
        ";

        $stmt = $this->db->prepare($sql);

        $searchValue = "%{$search}%";

        $stmt->bindValue(
            ':employee_no',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':first_name',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':last_name',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':email',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':job_title',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':department',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':location',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':branch',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':company',
            $searchValue,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find employee
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                e.*,

                jt.job_title,

                d.department_name,

                l.location_code,
                l.location_name,

                b.branch_code,
                b.branch_name,

                c.company_code,
                c.company_name

            FROM employees e

            LEFT JOIN job_titles jt
                ON jt.id = e.job_title_id

            LEFT JOIN departments d
                ON d.id = e.department_id

            LEFT JOIN locations l
                ON l.id = e.location_id

            LEFT JOIN branches b
                ON b.id = l.branch_id

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE e.id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check employee number
     */
    public function existsEmployeeNo(
        string $employeeNo,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {

            $stmt = $this->db->prepare("
                SELECT id
                FROM employees
                WHERE employee_no = ?
                AND id <> ?
                LIMIT 1
            ");

            $stmt->execute([
                $employeeNo,
                $excludeId
            ]);

        } else {

            $stmt = $this->db->prepare("
                SELECT id
                FROM employees
                WHERE employee_no = ?
                LIMIT 1
            ");

            $stmt->execute([
                $employeeNo
            ]);
        }

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Get active job titles
     *
     * Job Title is controlled master data.
     */
    public function jobTitles(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                job_title
            FROM job_titles
            WHERE status = 'Active'
            ORDER BY job_title ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get active departments
     */
    public function departments(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                department_name
            FROM departments
            WHERE status = 'Active'
            ORDER BY department_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get active locations
     */
    public function locations(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                l.id,
                l.location_code,
                l.location_name,

                b.branch_code,
                b.branch_name,

                c.company_code,
                c.company_name

            FROM locations l

            LEFT JOIN branches b
                ON b.id = l.branch_id

            LEFT JOIN companies c
                ON c.id = b.company_id

            WHERE l.status = 'Active'

            ORDER BY
                c.company_name ASC,
                b.branch_name ASC,
                l.location_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create employee
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO employees
            (
                employee_no,
                first_name,
                last_name,
                email,
                phone,
                job_title_id,
                department_id,
                location_id,
                employment_status,
                status
            )
            VALUES
            (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )
        ");

        return $stmt->execute([
            $data['employee_no'],
            $data['first_name'],
            $data['last_name'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['job_title_id'],
            $data['department_id'],
            $data['location_id'],
            $data['employment_status'] ?? 'Regular',
            $data['status'] ?? 'Active'
        ]);
    }

    /**
     * Update employee
     */
    public function update(
        int $id,
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE employees
            SET
                employee_no = ?,
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?,
                job_title_id = ?,
                department_id = ?,
                location_id = ?,
                employment_status = ?,
                status = ?

            WHERE id = ?
        ");

        return $stmt->execute([
            $data['employee_no'],
            $data['first_name'],
            $data['last_name'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['job_title_id'],
            $data['department_id'],
            $data['location_id'],
            $data['employment_status'] ?? 'Regular',
            $data['status'] ?? 'Active',
            $id
        ]);
    }

    /**
     * Deactivate employee
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE employees
            SET status = 'Inactive'
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}