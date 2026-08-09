<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Asset;
use Throwable;

class AssetService
{
    private Asset $asset;

    public function __construct()
    {
        $this->asset = new Asset();
    }

    public function all(
        string $search = '',
        array $filters = [],
        int $limit = 10,
        int $offset = 0
    ): array {
        return $this->asset->all(
            $search,
            $filters,
            $limit,
            $offset
        );
    }

    public function count(
        string $search = '',
        array $filters = []
    ): int {
        return $this->asset->count(
            $search,
            $filters
        );
    }

    public function find(int $id): array|false
    {
        return $this->asset->find($id);
    }

    public function lookupData(): array
    {
        return $this->asset->lookupData();
    }

    public function create(array $data): array
    {
        $normalized = $this->normalize($data);

        $validation = $this->validate($normalized);

        if (!$validation['success']) {
            return $validation;
        }

        if ($this->asset->existsAssetTag($normalized['asset_tag'])) {
            return [
                'success' => false,
                'message' => 'Asset Tag already exists.'
            ];
        }

        if (
            $normalized['serial_number'] !== '' &&
            $this->asset->existsSerialNumber(
                $normalized['serial_number']
            )
        ) {
            return [
                'success' => false,
                'message' => 'Serial Number already exists.'
            ];
        }

        try {
            $saved = $this->asset->create($normalized);

            return [
                'success' => $saved,
                'message' => $saved
                    ? 'Asset created successfully.'
                    : 'Unable to create asset.'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Unable to create asset.'
            ];
        }
    }

    public function update(
        int $id,
        array $data
    ): array {
        if ($id <= 0 || !$this->asset->find($id)) {
            return [
                'success' => false,
                'message' => 'Asset not found.'
            ];
        }

        $normalized = $this->normalize($data);

        $validation = $this->validate($normalized);

        if (!$validation['success']) {
            return $validation;
        }

        if (
            $this->asset->existsAssetTag(
                $normalized['asset_tag'],
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Asset Tag already exists.'
            ];
        }

        if (
            $normalized['serial_number'] !== '' &&
            $this->asset->existsSerialNumber(
                $normalized['serial_number'],
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Serial Number already exists.'
            ];
        }

        try {
            $updated = $this->asset->update(
                $id,
                $normalized
            );

            return [
                'success' => $updated,
                'message' => $updated
                    ? 'Asset updated successfully.'
                    : 'Unable to update asset.'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Unable to update asset.'
            ];
        }
    }

    private function normalize(array $data): array
    {
        return [
            'asset_tag' => strtoupper(trim((string)($data['asset_tag'] ?? ''))),
            'finance_asset_code' => $this->nullableString($data['finance_asset_code'] ?? null),
            'serial_number' => trim((string)($data['serial_number'] ?? '')),
            'asset_name' => trim((string)($data['asset_name'] ?? '')),
            'category_id' => $this->nullableInt($data['category_id'] ?? null),
            'brand_id' => $this->nullableInt($data['brand_id'] ?? null),
            'model_id' => $this->nullableInt($data['model_id'] ?? null),
            'manufacturer_id' => $this->nullableInt($data['manufacturer_id'] ?? null),
            'supplier_id' => $this->nullableInt($data['supplier_id'] ?? null),
            'company_id' => $this->nullableInt($data['company_id'] ?? null),
            'branch_id' => $this->nullableInt($data['branch_id'] ?? null),
            'department_id' => $this->nullableInt($data['department_id'] ?? null),
            'section_id' => $this->nullableInt($data['section_id'] ?? null),
            'location_id' => $this->nullableInt($data['location_id'] ?? null),
            'assigned_employee_id' => $this->nullableInt($data['assigned_employee_id'] ?? null),
            'purchase_date' => $this->nullableString($data['purchase_date'] ?? null),
            'purchase_cost' => $this->nullableDecimal($data['purchase_cost'] ?? null),
            'warranty_start' => $this->nullableString($data['warranty_start'] ?? null),
            'warranty_end' => $this->nullableString($data['warranty_end'] ?? null),
            'invoice_number' => $this->nullableString($data['invoice_number'] ?? null),
            'purchase_order_no' => $this->nullableString($data['purchase_order_no'] ?? null),
            'barcode' => $this->nullableString($data['barcode'] ?? null),
            'qr_code' => $this->nullableString($data['qr_code'] ?? null),
            'asset_condition' => trim((string)($data['asset_condition'] ?? 'New')),
            'asset_status' => trim((string)($data['asset_status'] ?? 'Available')),
            'remarks' => $this->nullableString($data['remarks'] ?? null)
        ];
    }

    private function validate(array $data): array
    {
        if ($data['asset_tag'] === '') {
            return ['success' => false, 'message' => 'Asset Tag is required.'];
        }

        if ($data['asset_name'] === '') {
            return ['success' => false, 'message' => 'Asset Name is required.'];
        }

        if (!$data['category_id']) {
            return ['success' => false, 'message' => 'Asset Category is required.'];
        }

        if (!$data['company_id']) {
            return ['success' => false, 'message' => 'Company is required.'];
        }

        if (!$data['branch_id']) {
            return ['success' => false, 'message' => 'Branch is required.'];
        }

        if (!$data['department_id']) {
            return ['success' => false, 'message' => 'Department is required.'];
        }

        $conditions = ['New', 'Good', 'Fair', 'Poor', 'Damaged'];
        $statuses = ['Available', 'Assigned', 'Maintenance', 'Repair', 'Disposed', 'Lost'];

        if (!in_array($data['asset_condition'], $conditions, true)) {
            return ['success' => false, 'message' => 'Invalid asset condition.'];
        }

        if (!in_array($data['asset_status'], $statuses, true)) {
            return ['success' => false, 'message' => 'Invalid asset status.'];
        }

        return ['success' => true, 'message' => 'Valid'];
    }

    private function nullableInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = (int)$value;

        return $value > 0 ? $value : null;
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string)($value ?? ''));

        return $value === '' ? null : $value;
    }

    private function nullableDecimal(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return number_format((float)$value, 2, '.', '');
    }
}
