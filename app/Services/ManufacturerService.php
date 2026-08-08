<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Manufacturer;

class ManufacturerService
{
    private Manufacturer $model;
    private AuditLogService $audit;

    public function __construct()
    {
        $this->model = new Manufacturer();
        $this->audit = new AuditLogService();
    }

    /**
     * Get all manufacturers
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
     * Count manufacturers
     */
    public function count(string $search = ''): int
    {
        return $this->model->count($search);
    }

    /**
     * Find manufacturer
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Create manufacturer
     */
    public function create(array $data): array
    {
        if (empty($data['manufacturer_code'])) {
            return [
                'success' => false,
                'message' => 'Manufacturer Code is required.'
            ];
        }

        if (empty($data['manufacturer_name'])) {
            return [
                'success' => false,
                'message' => 'Manufacturer Name is required.'
            ];
        }

        if ($this->model->existsCode($data['manufacturer_code'])) {
            return [
                'success' => false,
                'message' => 'Manufacturer Code already exists.'
            ];
        }

        if ($this->model->existsName($data['manufacturer_name'])) {
            return [
                'success' => false,
                'message' => 'Manufacturer Name already exists.'
            ];
        }

        $this->model->create($data);

        $this->audit->log(
            'Manufacturers',
            'CREATE',
            0,
            'Created Manufacturer [' .
            $data['manufacturer_code'] .
            ' - ' .
            $data['manufacturer_name'] .
            ']'
        );

        return [
            'success' => true,
            'message' => 'Manufacturer successfully created.'
        ];
    }

    /**
     * Update manufacturer
     */
    public function update(
        int $id,
        array $data
    ): array {

        $this->model->update($id, $data);

        $this->audit->log(
            'Manufacturers',
            'UPDATE',
            $id,
            'Updated Manufacturer [' .
            $data['manufacturer_code'] .
            ' - ' .
            $data['manufacturer_name'] .
            ']'
        );

        return [
            'success' => true,
            'message' => 'Manufacturer successfully updated.'
        ];
    }

    /**
     * Deactivate manufacturer
     */
    public function deactivate(int $id): array
    {
        $manufacturer = $this->model->find($id);

        if (!$manufacturer) {
            return [
                'success' => false,
                'message' => 'Manufacturer not found.'
            ];
        }

        $this->model->deactivate($id);

        $this->audit->log(
            'Manufacturers',
            'DEACTIVATE',
            $id,
            'Deactivated Manufacturer [' .
            $manufacturer['manufacturer_code'] .
            ' - ' .
            $manufacturer['manufacturer_name'] .
            ']'
        );

        return [
            'success' => true,
            'message' => 'Manufacturer successfully deactivated.'
        ];
    }
}