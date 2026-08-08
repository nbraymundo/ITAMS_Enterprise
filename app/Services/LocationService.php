<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Location;

class LocationService
{
    private Location $model;

    public function __construct()
    {
        $this->model = new Location();
    }

    /**
     * Get all locations
     */
    public function all(
        string $search = ''
    ): array {
        return $this->model->all($search);
    }

    /**
     * Find location
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Get active branches
     */
    public function branches(): array
    {
        return $this->model->branches();
    }

    /**
     * Create location
     */
    public function create(array $data): array
    {
        $branchId = (int) ($data['branch_id'] ?? 0);

        $locationCode = trim(
            (string) ($data['location_code'] ?? '')
        );

        $locationName = trim(
            (string) ($data['location_name'] ?? '')
        );

        if ($branchId <= 0) {
            return [
                'success' => false,
                'message' => 'Branch is required.'
            ];
        }

        if ($locationCode === '') {
            return [
                'success' => false,
                'message' => 'Location code is required.'
            ];
        }

        if ($locationName === '') {
            return [
                'success' => false,
                'message' => 'Location name is required.'
            ];
        }

        if ($this->model->existsCode($locationCode)) {
            return [
                'success' => false,
                'message' => 'Location code already exists.'
            ];
        }

        if ($this->model->existsName($locationName)) {
            return [
                'success' => false,
                'message' => 'Location name already exists.'
            ];
        }

        $data['branch_id'] = $branchId;

        $data['location_code'] = $locationCode;

        $data['location_name'] = $locationName;

        $data['floor'] = trim(
            (string) ($data['floor'] ?? '')
        );

        $data['room'] = trim(
            (string) ($data['room'] ?? '')
        );

        $data['description'] = trim(
            (string) ($data['description'] ?? '')
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
                    'message' => 'Unable to create location.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Location created successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create location.'
            ];
        }
    }

    /**
     * Update location
     */
    public function update(
        int $id,
        array $data
    ): array {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid location ID.'
            ];
        }

        $location = $this->model->find($id);

        if (!$location) {
            return [
                'success' => false,
                'message' => 'Location not found.'
            ];
        }

        $branchId = (int) ($data['branch_id'] ?? 0);

        $locationCode = trim(
            (string) ($data['location_code'] ?? '')
        );

        $locationName = trim(
            (string) ($data['location_name'] ?? '')
        );

        if ($branchId <= 0) {
            return [
                'success' => false,
                'message' => 'Branch is required.'
            ];
        }

        if ($locationCode === '') {
            return [
                'success' => false,
                'message' => 'Location code is required.'
            ];
        }

        if ($locationName === '') {
            return [
                'success' => false,
                'message' => 'Location name is required.'
            ];
        }

        if (
            $this->model->existsCode(
                $locationCode,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Location code already exists.'
            ];
        }

        if (
            $this->model->existsName(
                $locationName,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Location name already exists.'
            ];
        }

        $data['branch_id'] = $branchId;

        $data['location_code'] = $locationCode;

        $data['location_name'] = $locationName;

        $data['floor'] = trim(
            (string) ($data['floor'] ?? '')
        );

        $data['room'] = trim(
            (string) ($data['room'] ?? '')
        );

        $data['description'] = trim(
            (string) ($data['description'] ?? '')
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
                    'message' => 'Unable to update location.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Location updated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update location.'
            ];
        }
    }

    /**
     * Deactivate location
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid location ID.'
            ];
        }

        $location = $this->model->find($id);

        if (!$location) {
            return [
                'success' => false,
                'message' => 'Location not found.'
            ];
        }

        if (($location['status'] ?? '') === 'Inactive') {
            return [
                'success' => false,
                'message' => 'Location is already inactive.'
            ];
        }

        try {

            $result = $this->model->deactivate($id);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to deactivate location.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Location deactivated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate location.'
            ];
        }
    }
}