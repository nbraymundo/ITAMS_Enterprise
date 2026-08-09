<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Component;

class ComponentService
{
    private Component $component;

    public function __construct()
    {
        $this->component = new Component();
    }

    /**
     * Get all components
     */
    public function all(string $search = ''): array
    {
        return $this->component->all($search);
    }

    /**
     * Find component
     */
    public function find(int $id): array|false
    {
        if ($id <= 0) {
            return false;
        }

        return $this->component->find($id);
    }

    /**
     * Get active suppliers
     */
    public function suppliers(): array
    {
        return $this->component->suppliers();
    }

    /**
     * Create component
     */
    public function create(array $data): array
    {
        $componentCode = strtoupper(
            trim((string) ($data['component_code'] ?? ''))
        );

        $componentType = trim(
            (string) ($data['component_type'] ?? '')
        );

        $componentName = trim(
            (string) ($data['component_name'] ?? '')
        );

        $serialNumber = trim(
            (string) ($data['serial_number'] ?? '')
        );

        $quantity = (int) (
            $data['quantity'] ?? 1
        );

        if ($componentCode === '') {
            return [
                'success' => false,
                'message' => 'Component code is required.'
            ];
        }

        if ($componentType === '') {
            return [
                'success' => false,
                'message' => 'Component type is required.'
            ];
        }

        if ($componentName === '') {
            return [
                'success' => false,
                'message' => 'Component name is required.'
            ];
        }

        if ($quantity < 1) {
            return [
                'success' => false,
                'message' => 'Quantity must be at least 1.'
            ];
        }

        if (
            $this->component->existsByCode(
                $componentCode
            )
        ) {
            return [
                'success' => false,
                'message' => 'Component code already exists.'
            ];
        }

        if (
            $serialNumber !== '' &&
            $this->component->existsBySerialNumber(
                $serialNumber
            )
        ) {
            return [
                'success' => false,
                'message' => 'Serial number already exists.'
            ];
        }

        $data['component_code'] = $componentCode;
        $data['component_type'] = $componentType;
        $data['component_name'] = $componentName;
        $data['serial_number'] = $serialNumber;

        $id = $this->component->create($data);

        return [
            'success' => $id > 0,
            'message' => $id > 0
                ? 'Component created successfully.'
                : 'Unable to create component.',
            'id' => $id
        ];
    }

    /**
     * Update component
     */
    public function update(
        int $id,
        array $data
    ): array {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid component ID.'
            ];
        }

        $component = $this->component->find($id);

        if ($component === false) {
            return [
                'success' => false,
                'message' => 'Component not found.'
            ];
        }

        $componentCode = strtoupper(
            trim((string) ($data['component_code'] ?? ''))
        );

        $componentType = trim(
            (string) ($data['component_type'] ?? '')
        );

        $componentName = trim(
            (string) ($data['component_name'] ?? '')
        );

        $serialNumber = trim(
            (string) ($data['serial_number'] ?? '')
        );

        $quantity = (int) (
            $data['quantity'] ?? 1
        );

        if ($componentCode === '') {
            return [
                'success' => false,
                'message' => 'Component code is required.'
            ];
        }

        if ($componentType === '') {
            return [
                'success' => false,
                'message' => 'Component type is required.'
            ];
        }

        if ($componentName === '') {
            return [
                'success' => false,
                'message' => 'Component name is required.'
            ];
        }

        if ($quantity < 1) {
            return [
                'success' => false,
                'message' => 'Quantity must be at least 1.'
            ];
        }

        if (
            $this->component->existsByCode(
                $componentCode,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Component code already exists.'
            ];
        }

        if (
            $serialNumber !== '' &&
            $this->component->existsBySerialNumber(
                $serialNumber,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Serial number already exists.'
            ];
        }

        $data['component_code'] = $componentCode;
        $data['component_type'] = $componentType;
        $data['component_name'] = $componentName;
        $data['serial_number'] = $serialNumber;

        $success = $this->component->update(
            $id,
            $data
        );

        return [
            'success' => $success,
            'message' => $success
                ? 'Component updated successfully.'
                : 'Unable to update component.'
        ];
    }

    /**
     * Delete component
     */
    public function delete(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid component ID.'
            ];
        }

        $component = $this->component->find($id);

        if ($component === false) {
            return [
                'success' => false,
                'message' => 'Component not found.'
            ];
        }

        /*
         * Installed components will later be protected
         * once component-to-asset assignment is implemented.
         */

        $success = $this->component->delete($id);

        return [
            'success' => $success,
            'message' => $success
                ? 'Component deleted successfully.'
                : 'Unable to delete component.'
        ];
    }
}