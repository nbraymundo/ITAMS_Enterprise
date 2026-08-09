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
                e.id,
                e.employee_no,

                e.first_name,
                e.middle_name,
                e.last_name,

                e.company_id,
                e.branch_id,
                e.department_id,
                e.section_id,
                e.location_id,
                e.job_title_id,

                e.email,
                e.mobile_no,
                e.employment_status,
                e.hired_date,

                jt.job_title_code,
                jt.job_title,

                d.department_code,
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
                ON b.id = e.branch_id

            LEFT JOIN companies c
                ON c.id = e.company_id

            WHERE
                e.employee_no LIKE :employee_no

                OR e.first_name LIKE :first_name

                OR e.middle_name LIKE :middle_name

                OR e.last_name LIKE :last_name

                OR e.email LIKE :email

                OR e.mobile_no LIKE :mobile_no

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
            ':middle_name',
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
            ':mobile_no',
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
                e.id,
                e.employee_no,

                e.first_name,
                e.middle_name,
                e.last_name,

                e.company_id,
                e.branch_id,
                e.department_id,
                e.section_id,
                e.location_id,
                e.job_title_id,

                e.email,
                e.mobile_no,
                e.employment_status,
                e.hired_date,

                jt.job_title_code,
                jt.job_title,

                d.department_code,
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
                ON b.id = e.branch_id

            LEFT JOIN companies c
                ON c.id = e.company_id

            WHERE e.id = ?

            LIMIT 1
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
     * Get active Job Titles
     */
    public function jobTitles(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                job_title_code,
                job_title

            FROM job_titles

            WHERE status = 'Active'

            ORDER BY job_title ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get active Companies
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
     * Get active Branches
     */
    public function branches(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                branch_code,
                branch_name,
                company_id

            FROM branches

            WHERE status = 'Active'

            ORDER BY branch_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get active Departments
     */
    public function departments(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                department_code,
                department_name

            FROM departments

            WHERE status = 'Active'

            ORDER BY department_name ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get active Locations
     */
    public function locations(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                l.id,
                l.location_code,
                l.location_name,

                l.branch_id,

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
                middle_name,
                last_name,

                company_id,
                branch_id,
                department_id,
                section_id,
                location_id,
                job_title_id,

                email,
                mobile_no,
                employment_status,
                hired_date
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,

                ?,
                ?,
                ?,
                ?,
                ?,
                ?,

                ?,
                ?,
                ?,
                ?
            )
        ");

        return $stmt->execute([
            $data['employee_no'],
            $data['first_name'],
            $data['middle_name'] ?? null,
            $data['last_name'],

            $data['company_id'],
            $data['branch_id'],
            $data['department_id'],
            $data['section_id'] ?? null,
            $data['location_id'] ?? null,
            $data['job_title_id'],

            $data['email'] ?? null,
            $data['mobile_no'] ?? null,
            $data['employment_status'] ?? 'Active',
            $data['hired_date'] ?? null
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
                middle_name = ?,
                last_name = ?,

                company_id = ?,
                branch_id = ?,
                department_id = ?,
                section_id = ?,
                location_id = ?,
                job_title_id = ?,

                email = ?,
                mobile_no = ?,
                employment_status = ?,
                hired_date = ?

            WHERE id = ?
        ");

        return $stmt->execute([
            $data['employee_no'],
            $data['first_name'],
            $data['middle_name'] ?? null,
            $data['last_name'],

            $data['company_id'],
            $data['branch_id'],
            $data['department_id'],
            $data['section_id'] ?? null,
            $data['location_id'] ?? null,
            $data['job_title_id'],

            $data['email'] ?? null,
            $data['mobile_no'] ?? null,
            $data['employment_status'] ?? 'Active',
            $data['hired_date'] ?? null,

            $id
        ]);
    }

    /**
     * Deactivate employee
     *
     * Employee status is controlled by
     * employment_status in the actual schema.
     */
    public function deactivate(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE employees

            SET employment_status = 'Inactive'

            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}