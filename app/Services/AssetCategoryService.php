<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AssetCategory;

class AssetCategoryService
{
    private AssetCategory $model;
    private AuditLogService $audit;

    public function __construct()
    {
        $this->model = new AssetCategory();
        $this->audit = new AuditLogService();
    }

    /**
     * Get Categories
     */
    public function all(
        string $search = '',
        int $page = 1,
        int $perPage = 10,
        string $sort = 'category_name',
        string $direction = 'ASC'
    ): array {
        return $this->model->all(
            $search,
            $page,
            $perPage,
            $sort,
            $direction
        );
    }

    /**
     * Total Records
     */
    public function countAll(string $search = ''): int
    {
        return $this->model->countAll($search);
    }

    /**
     * Find Category
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Create Category
     */
    public function create(array $data): array
    {
        if (trim($data['category_code']) === '') {
            return [
                'success' => false,
                'message' => 'Category Code is required.'
            ];
        }

        if (trim($data['category_name']) === '') {
            return [
                'success' => false,
                'message' => 'Category Name is required.'
            ];
        }

        if ($this->model->existsCode($data['category_code'])) {
            return [
                'success' => false,
                'message' => 'Category Code already exists.'
            ];
        }

        if ($this->model->existsName($data['category_name'])) {
            return [
                'success' => false,
                'message' => 'Category Name already exists.'
            ];
        }

        if (!$this->model->create($data)) {
            return [
                'success' => false,
                'message' => 'Unable to create category.'
            ];
        }

        $this->audit->log(
            'Asset Categories',
            'CREATE',
            null,
            'Created category: ' . $data['category_code']
        );

        return [
            'success' => true,
            'message' => 'Category successfully created.'
        ];
    }

    /**
     * Update Category
     */
    public function update(
        int $id,
        array $data
    ): array {

        if (trim($data['category_code']) === '') {
            return [
                'success' => false,
                'message' => 'Category Code is required.'
            ];
        }

        if (trim($data['category_name']) === '') {
            return [
                'success' => false,
                'message' => 'Category Name is required.'
            ];
        }

        if ($this->model->existsCodeExcept(
            $id,
            $data['category_code']
        )) {
            return [
                'success' => false,
                'message' => 'Category Code already exists.'
            ];
        }

        if ($this->model->existsNameExcept(
            $id,
            $data['category_name']
        )) {
            return [
                'success' => false,
                'message' => 'Category Name already exists.'
            ];
        }

        if (!$this->model->update(
            $id,
            $data
        )) {
            return [
                'success' => false,
                'message' => 'Unable to update category.'
            ];
        }

        $this->audit->log(
            'Asset Categories',
            'UPDATE',
            $id,
            'Updated category: ' . $data['category_code']
        );

        return [
            'success' => true,
            'message' => 'Category updated successfully.'
        ];
    }

    /**
     * Deactivate Category
     */
    public function deactivate(int $id): array
    {
        $assetCount = $this->model->assetCount($id);

        if ($assetCount > 0) {
            return [
                'success' => false,
                'message' => "Cannot deactivate category. {$assetCount} asset(s) are still assigned."
            ];
        }

        if (!$this->model->deactivate($id)) {
            return [
                'success' => false,
                'message' => 'Unable to deactivate category.'
            ];
        }

        $this->audit->log(
            'Asset Categories',
            'DEACTIVATE',
            $id,
            'Deactivated category'
        );

        return [
            'success' => true,
            'message' => 'Category deactivated successfully.'
        ];
    }
}