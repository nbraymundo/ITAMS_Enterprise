<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;

class CompanyService
{
    private Company $model;

    public function __construct()
    {
        $this->model = new Company();
    }

    /**
     * Get companies
     */
    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {
        return $this->model->all(
            $search,
            $limit,
            $offset
        );
    }

    /**
     * Count companies
     */
    public function count(string $search = ''): int
    {
        return $this->model->count($search);
    }

    /**
     * Find company
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Create company
     */
    public function create(array $data): array
    {
        $companyCode = trim(
            (string) ($data['company_code'] ?? '')
        );

        $companyName = trim(
            (string) ($data['company_name'] ?? '')
        );

        if ($companyCode === '') {
            return [
                'success' => false,
                'message' => 'Company code is required.'
            ];
        }

        if ($companyName === '') {
            return [
                'success' => false,
                'message' => 'Company name is required.'
            ];
        }

        if ($this->model->existsCode($companyCode)) {
            return [
                'success' => false,
                'message' => 'Company code already exists.'
            ];
        }

        if ($this->model->existsName($companyName)) {
            return [
                'success' => false,
                'message' => 'Company name already exists.'
            ];
        }

        $data['company_code'] = $companyCode;
        $data['company_name'] = $companyName;

        $data['address'] = trim(
            (string) ($data['address'] ?? '')
        );

        $data['telephone'] = trim(
            (string) ($data['telephone'] ?? '')
        );

        $data['email'] = trim(
            (string) ($data['email'] ?? '')
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
                    'message' => 'Unable to create company.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Company created successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create company.'
            ];
        }
    }

    /**
     * Update company
     */
    public function update(
        int $id,
        array $data
    ): array {

        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid company ID.'
            ];
        }

        $company = $this->model->find($id);

        if (!$company) {
            return [
                'success' => false,
                'message' => 'Company not found.'
            ];
        }

        $companyCode = trim(
            (string) ($data['company_code'] ?? '')
        );

        $companyName = trim(
            (string) ($data['company_name'] ?? '')
        );

        if ($companyCode === '') {
            return [
                'success' => false,
                'message' => 'Company code is required.'
            ];
        }

        if ($companyName === '') {
            return [
                'success' => false,
                'message' => 'Company name is required.'
            ];
        }

        if (
            $this->model->existsCode(
                $companyCode,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Company code already exists.'
            ];
        }

        if (
            $this->model->existsName(
                $companyName,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Company name already exists.'
            ];
        }

        $data['company_code'] = $companyCode;
        $data['company_name'] = $companyName;

        $data['address'] = trim(
            (string) ($data['address'] ?? '')
        );

        $data['telephone'] = trim(
            (string) ($data['telephone'] ?? '')
        );

        $data['email'] = trim(
            (string) ($data['email'] ?? '')
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
                    'message' => 'Unable to update company.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Company updated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update company.'
            ];
        }
    }

    /**
     * Deactivate company
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid company ID.'
            ];
        }

        $company = $this->model->find($id);

        if (!$company) {
            return [
                'success' => false,
                'message' => 'Company not found.'
            ];
        }

        if (($company['status'] ?? '') === 'Inactive') {
            return [
                'success' => false,
                'message' => 'Company is already inactive.'
            ];
        }

        try {

            $result = $this->model->deactivate($id);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to deactivate company.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Company deactivated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate company.'
            ];
        }
    }
}