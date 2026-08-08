<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Branch;

class BranchService
{
    private Branch $model;

    public function __construct()
    {
        $this->model = new Branch();
    }

    /**
     * Get all branches
     */
    public function all(
        string $search = ''
    ): array {
        return $this->model->all($search);
    }

    /**
     * Find branch
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Get active companies
     */
    public function companies(): array
    {
        return $this->model->companies();
    }

    /**
     * Create branch
     */
    public function create(array $data): array
    {
        $companyId = (int) ($data['company_id'] ?? 0);

        $branchCode = trim(
            (string) ($data['branch_code'] ?? '')
        );

        $branchName = trim(
            (string) ($data['branch_name'] ?? '')
        );

        if ($companyId <= 0) {
            return [
                'success' => false,
                'message' => 'Company is required.'
            ];
        }

        if ($branchCode === '') {
            return [
                'success' => false,
                'message' => 'Branch code is required.'
            ];
        }

        if ($branchName === '') {
            return [
                'success' => false,
                'message' => 'Branch name is required.'
            ];
        }

        if ($this->model->existsCode($branchCode)) {
            return [
                'success' => false,
                'message' => 'Branch code already exists.'
            ];
        }

        if ($this->model->existsName($branchName)) {
            return [
                'success' => false,
                'message' => 'Branch name already exists.'
            ];
        }

        $data['company_id'] = $companyId;

        $data['branch_code'] = $branchCode;

        $data['branch_name'] = $branchName;

        $data['address'] = trim(
            (string) ($data['address'] ?? '')
        );

        $data['status'] = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        try {

            $result = $this->model->create($data);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to create branch.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Branch created successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create branch.'
            ];
        }
    }

    /**
     * Update branch
     */
    public function update(
        int $id,
        array $data
    ): array {

        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid branch ID.'
            ];
        }

        $branch = $this->model->find($id);

        if (!$branch) {
            return [
                'success' => false,
                'message' => 'Branch not found.'
            ];
        }

        $companyId = (int) ($data['company_id'] ?? 0);

        $branchCode = trim(
            (string) ($data['branch_code'] ?? '')
        );

        $branchName = trim(
            (string) ($data['branch_name'] ?? '')
        );

        if ($companyId <= 0) {
            return [
                'success' => false,
                'message' => 'Company is required.'
            ];
        }

        if ($branchCode === '') {
            return [
                'success' => false,
                'message' => 'Branch code is required.'
            ];
        }

        if ($branchName === '') {
            return [
                'success' => false,
                'message' => 'Branch name is required.'
            ];
        }

        if (
            $this->model->existsCode(
                $branchCode,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Branch code already exists.'
            ];
        }

        if (
            $this->model->existsName(
                $branchName,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Branch name already exists.'
            ];
        }

        $data['company_id'] = $companyId;

        $data['branch_code'] = $branchCode;

        $data['branch_name'] = $branchName;

        $data['address'] = trim(
            (string) ($data['address'] ?? '')
        );

        $data['status'] = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        try {

            $result = $this->model->update(
                $id,
                $data
            );

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to update branch.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Branch updated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update branch.'
            ];
        }
    }

    /**
     * Deactivate branch
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid branch ID.'
            ];
        }

        $branch = $this->model->find($id);

        if (!$branch) {
            return [
                'success' => false,
                'message' => 'Branch not found.'
            ];
        }

        if (($branch['status'] ?? '') === 'Inactive') {
            return [
                'success' => false,
                'message' => 'Branch is already inactive.'
            ];
        }

        try {

            $result = $this->model->deactivate($id);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to deactivate branch.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Branch deactivated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate branch.'
            ];
        }
    }
}