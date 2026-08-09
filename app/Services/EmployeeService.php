<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    private Employee $employee;

    public function __construct()
    {
        $this->employee = new Employee();
    }

    /**
     * Get all employees
     */
    public function all(string $search = ''): array
    {
        return $this->employee->all($search);
    }

    /**
     * Find employee
     */
    public function find(int $id): array|false
    {
        if ($id <= 0) {
            return false;
        }

        return $this->employee->find($id);
    }

    /**
     * Get active Job Titles
     */
    public function jobTitles(): array
    {
        return $this->employee->jobTitles();
    }

    /**
     * Get active Companies
     */
    public function companies(): array
    {
        return $this->employee->companies();
    }

    /**
     * Get active Branches
     */
    public function branches(): array
    {
        return $this->employee->branches();
    }

    /**
     * Get active Departments
     */
    public function departments(): array
    {
        return $this->employee->departments();
    }

    /**
     * Get active Locations
     */
    public function locations(): array
    {
        return $this->employee->locations();
    }

    /**
     * Create Employee
     */
    public function create(array $data): array
    {
        $employeeNo = strtoupper(
            trim((string) ($data['employee_no'] ?? ''))
        );

        $firstName = trim(
            (string) ($data['first_name'] ?? '')
        );

        $middleName = trim(
            (string) ($data['middle_name'] ?? '')
        );

        $lastName = trim(
            (string) ($data['last_name'] ?? '')
        );

        $companyId = (int) (
            $data['company_id'] ?? 0
        );

        $branchId = (int) (
            $data['branch_id'] ?? 0
        );

        $departmentId = (int) (
            $data['department_id'] ?? 0
        );

        $sectionId = (int) (
            $data['section_id'] ?? 0
        );

        $locationId = (int) (
            $data['location_id'] ?? 0
        );

        $jobTitleId = (int) (
            $data['job_title_id'] ?? 0
        );

        $email = trim(
            (string) ($data['email'] ?? '')
        );

        $mobileNo = trim(
            (string) ($data['mobile_no'] ?? '')
        );

        $employmentStatus = trim(
            (string) (
                $data['employment_status']
                ?? 'Active'
            )
        );

        $hiredDate = trim(
            (string) ($data['hired_date'] ?? '')
        );

        $status = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($employeeNo === '') {
            return [
                'success' => false,
                'message' => 'Employee Number is required.'
            ];
        }

        if ($firstName === '') {
            return [
                'success' => false,
                'message' => 'First Name is required.'
            ];
        }

        if ($lastName === '') {
            return [
                'success' => false,
                'message' => 'Last Name is required.'
            ];
        }

        if ($companyId <= 0) {
            return [
                'success' => false,
                'message' => 'Company is required.'
            ];
        }

        if ($branchId <= 0) {
            return [
                'success' => false,
                'message' => 'Branch is required.'
            ];
        }

        if ($departmentId <= 0) {
            return [
                'success' => false,
                'message' => 'Department is required.'
            ];
        }

        if ($jobTitleId <= 0) {
            return [
                'success' => false,
                'message' => 'Job Title is required.'
            ];
        }

        if (
            $email !== ''
            && !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            return [
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ];
        }

        if (
            $hiredDate !== ''
            && !$this->validDate($hiredDate)
        ) {
            return [
                'success' => false,
                'message' => 'Please enter a valid hired date.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Employment Status
        |--------------------------------------------------------------------------
        */

        $allowedEmploymentStatuses = [
            'Active',
            'Inactive',
            'Resigned',
            'Terminated'
        ];

        if (
            !in_array(
                $employmentStatus,
                $allowedEmploymentStatuses,
                true
            )
        ) {
            return [
                'success' => false,
                'message' => 'Invalid employment status.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Employee Number
        |--------------------------------------------------------------------------
        */

        if (
            $this->employee->existsEmployeeNo(
                $employeeNo
            )
        ) {
            return [
                'success' => false,
                'message' => 'Employee Number already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        try {

            $result = $this->employee->create([
                'employee_no' => $employeeNo,

                'first_name' => $firstName,

                'middle_name' => $middleName !== ''
                    ? $middleName
                    : null,

                'last_name' => $lastName,

                'company_id' => $companyId,

                'branch_id' => $branchId,

                'department_id' => $departmentId,

                'section_id' => $sectionId > 0
                    ? $sectionId
                    : null,

                'location_id' => $locationId > 0
                    ? $locationId
                    : null,

                'job_title_id' => $jobTitleId,

                'email' => $email !== ''
                    ? $email
                    : null,

                'mobile_no' => $mobileNo !== ''
                    ? $mobileNo
                    : null,

                'employment_status' =>
                    $employmentStatus,

                'hired_date' => $hiredDate !== ''
                    ? $hiredDate
                    : null,

                'status' => $status
            ]);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to create employee.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Employee created successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create employee.'
            ];
        }
    }

    /**
     * Update Employee
     */
    public function update(
        int $id,
        array $data
    ): array {

        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid employee ID.'
            ];
        }

        $existing = $this->employee->find($id);

        if (!$existing) {
            return [
                'success' => false,
                'message' => 'Employee not found.'
            ];
        }

        $employeeNo = strtoupper(
            trim((string) ($data['employee_no'] ?? ''))
        );

        $firstName = trim(
            (string) ($data['first_name'] ?? '')
        );

        $middleName = trim(
            (string) ($data['middle_name'] ?? '')
        );

        $lastName = trim(
            (string) ($data['last_name'] ?? '')
        );

        $companyId = (int) (
            $data['company_id'] ?? 0
        );

        $branchId = (int) (
            $data['branch_id'] ?? 0
        );

        $departmentId = (int) (
            $data['department_id'] ?? 0
        );

        $sectionId = (int) (
            $data['section_id'] ?? 0
        );

        $locationId = (int) (
            $data['location_id'] ?? 0
        );

        $jobTitleId = (int) (
            $data['job_title_id'] ?? 0
        );

        $email = trim(
            (string) ($data['email'] ?? '')
        );

        $mobileNo = trim(
            (string) ($data['mobile_no'] ?? '')
        );

        $employmentStatus = trim(
            (string) (
                $data['employment_status']
                ?? 'Active'
            )
        );

        $hiredDate = trim(
            (string) ($data['hired_date'] ?? '')
        );

        $status = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($employeeNo === '') {
            return [
                'success' => false,
                'message' => 'Employee Number is required.'
            ];
        }

        if ($firstName === '') {
            return [
                'success' => false,
                'message' => 'First Name is required.'
            ];
        }

        if ($lastName === '') {
            return [
                'success' => false,
                'message' => 'Last Name is required.'
            ];
        }

        if ($companyId <= 0) {
            return [
                'success' => false,
                'message' => 'Company is required.'
            ];
        }

        if ($branchId <= 0) {
            return [
                'success' => false,
                'message' => 'Branch is required.'
            ];
        }

        if ($departmentId <= 0) {
            return [
                'success' => false,
                'message' => 'Department is required.'
            ];
        }

        if ($jobTitleId <= 0) {
            return [
                'success' => false,
                'message' => 'Job Title is required.'
            ];
        }

        if (
            $email !== ''
            && !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            return [
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ];
        }

        if (
            $hiredDate !== ''
            && !$this->validDate($hiredDate)
        ) {
            return [
                'success' => false,
                'message' => 'Please enter a valid hired date.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Employment Status
        |--------------------------------------------------------------------------
        */

        $allowedEmploymentStatuses = [
            'Active',
            'Inactive',
            'Resigned',
            'Terminated'
        ];

        if (
            !in_array(
                $employmentStatus,
                $allowedEmploymentStatuses,
                true
            )
        ) {
            return [
                'success' => false,
                'message' => 'Invalid employment status.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Employee Number
        |--------------------------------------------------------------------------
        */

        if (
            $this->employee->existsEmployeeNo(
                $employeeNo,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Employee Number already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        try {

            $result = $this->employee->update(
                $id,
                [
                    'employee_no' => $employeeNo,

                    'first_name' => $firstName,

                    'middle_name' => $middleName !== ''
                        ? $middleName
                        : null,

                    'last_name' => $lastName,

                    'company_id' => $companyId,

                    'branch_id' => $branchId,

                    'department_id' => $departmentId,

                    'section_id' => $sectionId > 0
                        ? $sectionId
                        : null,

                    'location_id' => $locationId > 0
                        ? $locationId
                        : null,

                    'job_title_id' => $jobTitleId,

                    'email' => $email !== ''
                        ? $email
                        : null,

                    'mobile_no' => $mobileNo !== ''
                        ? $mobileNo
                        : null,

                    'employment_status' =>
                        $employmentStatus,

                    'hired_date' => $hiredDate !== ''
                        ? $hiredDate
                        : null,

                    'status' => $status
                ]
            );

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to update employee.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Employee updated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update employee.'
            ];
        }
    }

    /**
     * Deactivate Employee
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid employee ID.'
            ];
        }

        $existing = $this->employee->find($id);

        if (!$existing) {
            return [
                'success' => false,
                'message' => 'Employee not found.'
            ];
        }

        if (
            ($existing['status'] ?? '')
            === 'Inactive'
        ) {
            return [
                'success' => false,
                'message' => 'Employee is already inactive.'
            ];
        }

        try {

            $result = $this->employee->deactivate($id);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to deactivate employee.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Employee deactivated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate employee.'
            ];
        }
    }

    /**
     * Validate date
     */
    private function validDate(string $date): bool
    {
        $parsed = \DateTime::createFromFormat(
            'Y-m-d',
            $date
        );

        return $parsed !== false
            && $parsed->format('Y-m-d') === $date;
    }
}