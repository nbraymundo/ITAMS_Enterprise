<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    private Department $model;

    public function __construct()
    {
        $this->model = new Department();
    }

    /**
     * Get all departments
     */
    public function all(string $search = ''): array
    {
        return $this->model->all($search);
    }

    /**
     * Find department
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Get active departments
     *
     * Used by Employee and other modules.
     */
    public function active(): array
    {
        return $this->model->active();
    }

    /**
     * Create department
     */
    public function create(array $data): array
    {
        $departmentCode = trim(
            $data['department_code'] ?? ''
        );

        $departmentName = trim(
            $data['department_name'] ?? ''
        );

        $description = trim(
            $data['description'] ?? ''
        );

        $status = $data['status'] ?? 'Active';


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($departmentCode === '') {

            return [
                'success' => false,
                'message' => 'Department code is required.'
            ];
        }


        if ($departmentName === '') {

            return [
                'success' => false,
                'message' => 'Department name is required.'
            ];
        }


        if (!in_array(
            $status,
            ['Active', 'Inactive'],
            true
        )) {

            return [
                'success' => false,
                'message' => 'Invalid department status.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Duplicate Department Code
        |--------------------------------------------------------------------------
        */

        if ($this->model->existsCode(
            $departmentCode
        )) {

            return [
                'success' => false,
                'message' => 'Department code already exists.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Duplicate Department Name
        |--------------------------------------------------------------------------
        */

        if ($this->model->existsName(
            $departmentName
        )) {

            return [
                'success' => false,
                'message' => 'Department name already exists.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        try {

            $created = $this->model->create([
                'department_code' => $departmentCode,

                'department_name' => $departmentName,

                'description' => (
                    $description !== ''
                        ? $description
                        : null
                ),

                'status' => $status
            ]);

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create department.'
            ];
        }


        if (!$created) {

            return [
                'success' => false,
                'message' => 'Unable to create department.'
            ];
        }


        return [
            'success' => true,
            'message' => 'Department created successfully.'
        ];
    }

    /**
     * Update department
     */
    public function update(
        int $id,
        array $data
    ): array {

        if ($id <= 0) {

            return [
                'success' => false,
                'message' => 'Invalid department ID.'
            ];
        }


        $department = $this->model->find($id);

        if (!$department) {

            return [
                'success' => false,
                'message' => 'Department not found.'
            ];
        }


        $departmentCode = trim(
            $data['department_code'] ?? ''
        );

        $departmentName = trim(
            $data['department_name'] ?? ''
        );

        $description = trim(
            $data['description'] ?? ''
        );

        $status = $data['status'] ?? 'Active';


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($departmentCode === '') {

            return [
                'success' => false,
                'message' => 'Department code is required.'
            ];
        }


        if ($departmentName === '') {

            return [
                'success' => false,
                'message' => 'Department name is required.'
            ];
        }


        if (!in_array(
            $status,
            ['Active', 'Inactive'],
            true
        )) {

            return [
                'success' => false,
                'message' => 'Invalid department status.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Duplicate Department Code
        |--------------------------------------------------------------------------
        */

        if ($this->model->existsCode(
            $departmentCode,
            $id
        )) {

            return [
                'success' => false,
                'message' => 'Department code already exists.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Duplicate Department Name
        |--------------------------------------------------------------------------
        */

        if ($this->model->existsName(
            $departmentName,
            $id
        )) {

            return [
                'success' => false,
                'message' => 'Department name already exists.'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        try {

            $updated = $this->model->update(
                $id,
                [
                    'department_code' => $departmentCode,

                    'department_name' => $departmentName,

                    'description' => (
                        $description !== ''
                            ? $description
                            : null
                    ),

                    'status' => $status
                ]
            );

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update department.'
            ];
        }


        if (!$updated) {

            return [
                'success' => false,
                'message' => 'Unable to update department.'
            ];
        }


        return [
            'success' => true,
            'message' => 'Department updated successfully.'
        ];
    }

    /**
     * Deactivate department
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {

            return [
                'success' => false,
                'message' => 'Invalid department ID.'
            ];
        }


        $department = $this->model->find($id);

        if (!$department) {

            return [
                'success' => false,
                'message' => 'Department not found.'
            ];
        }


        if (
            ($department['status'] ?? '')
            === 'Inactive'
        ) {

            return [
                'success' => false,
                'message' => 'Department is already inactive.'
            ];
        }


        try {

            $updated = $this->model->deactivate(
                $id
            );

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate department.'
            ];
        }


        if (!$updated) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate department.'
            ];
        }


        return [
            'success' => true,
            'message' => 'Department deactivated successfully.'
        ];
    }
}