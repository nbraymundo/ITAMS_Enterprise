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

    public function countAll(string $search = ''): int
    {
        return $this->model->countAll($search);
    }

    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    public function create(array $data): array
    {
        $data = $this->normalize($data);

        $validation = $this->validate($data);

        if ($validation !== null) {
            return [
                'success' => false,
                'message' => $validation
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
            'Created category: '
            . $data['category_code']
            . ' | Device Specs: '
            . ($data['has_device_specs'] ? 'Yes' : 'No')
        );

        return [
            'success' => true,
            'message' => 'Category successfully created.'
        ];
    }

    public function update(
        int $id,
        array $data
    ): array {
        $data = $this->normalize($data);

        $validation = $this->validate($data);

        if ($validation !== null) {
            return [
                'success' => false,
                'message' => $validation
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

        if (!$this->model->update($id, $data)) {
            return [
                'success' => false,
                'message' => 'Unable to update category.'
            ];
        }

        $this->audit->log(
            'Asset Categories',
            'UPDATE',
            $id,
            'Updated category: '
            . $data['category_code']
            . ' | Device Specs: '
            . ($data['has_device_specs'] ? 'Yes' : 'No')
        );

        return [
            'success' => true,
            'message' => 'Category updated successfully.'
        ];
    }

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

    private function normalize(array $data): array
    {
        return [
            'category_code' => strtoupper(
                trim((string) ($data['category_code'] ?? ''))
            ),
            'category_name' => trim(
                (string) ($data['category_name'] ?? '')
            ),
            'description' => trim(
                (string) ($data['description'] ?? '')
            ),
            'has_device_specs' => !empty(
                $data['has_device_specs']
            ) ? 1 : 0,
            'icon' => trim(
                (string) ($data['icon'] ?? '')
            ),
            'color' => trim(
                (string) ($data['color'] ?? '')
            ),
            'sort_order' => (int) (
                $data['sort_order'] ?? 0
            ),
            'status' => (
                ($data['status'] ?? 'Active') === 'Inactive'
            ) ? 'Inactive' : 'Active',
        ];
    }

    private function validate(array $data): ?string
    {
        if ($data['category_code'] === '') {
            return 'Category Code is required.';
        }

        if ($data['category_name'] === '') {
            return 'Category Name is required.';
        }

        if ($data['sort_order'] < 0) {
            return 'Sort Order cannot be negative.';
        }

        return null;
    }
}
