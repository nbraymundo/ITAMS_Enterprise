<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    private Brand $model;

    private AuditLogService $audit;

    public function __construct()
    {
        $this->model = new Brand();
        $this->audit = new AuditLogService();
    }

    /**
     * Get all brands
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
     * Count brands
     */
    public function count(string $search = ''): int
    {
        return $this->model->count($search);
    }

    /**
     * Find brand
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Manufacturer dropdown
     */
    public function manufacturerList(): array
    {
        return $this->model->manufacturerList();
    }

    /**
     * Create brand
     */
    public function create(array $data): array
    {
        if (empty($data['brand_code'])) {
            return [
                'success' => false,
                'message' => 'Brand Code is required.'
            ];
        }

        if (empty($data['brand_name'])) {
            return [
                'success' => false,
                'message' => 'Brand Name is required.'
            ];
        }

        if (empty($data['manufacturer_id'])) {
            return [
                'success' => false,
                'message' => 'Manufacturer is required.'
            ];
        }

        if ($this->model->existsCode($data['brand_code'])) {
            return [
                'success' => false,
                'message' => 'Brand Code already exists.'
            ];
        }

        if ($this->model->existsName($data['brand_name'])) {
            return [
                'success' => false,
                'message' => 'Brand Name already exists.'
            ];
        }

        $this->model->create($data);

        $this->audit->log(
            'Asset Brands',
            'CREATE',
            null,
            sprintf(
                'Created Asset Brand [%s - %s]',
                $data['brand_code'],
                $data['brand_name']
            )
        );

        return [
            'success' => true,
            'message' => 'Brand successfully created.'
        ];
    }

    /**
     * Update brand
     */
    public function update(
        int $id,
        array $data
    ): array {

        $this->model->update(
            $id,
            $data
        );

        $this->audit->log(
            'Asset Brands',
            'UPDATE',
            $id,
            sprintf(
                'Updated Asset Brand [%s - %s]',
                $data['brand_code'],
                $data['brand_name']
            )
        );

        return [
            'success' => true,
            'message' => 'Brand successfully updated.'
        ];
    }

    /**
     * Deactivate brand
     */
    public function deactivate(int $id): array
    {
        $brand = $this->model->find($id);

        $this->model->deactivate($id);

        $this->audit->log(
            'Asset Brands',
            'DEACTIVATE',
            $id,
            sprintf(
                'Deactivated Asset Brand [%s - %s]',
                $brand['brand_code'] ?? '',
                $brand['brand_name'] ?? ''
            )
        );

        return [
            'success' => true,
            'message' => 'Brand successfully deactivated.'
        ];
    }
}