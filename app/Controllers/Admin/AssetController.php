<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Middleware\AuthMiddleware;
use App\Models\Asset;

class AssetController
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $assetModel = new Asset();

        $search = trim((string)($_GET['search'] ?? ''));
        $filters = [
            'category_id' => (int)($_GET['category_id'] ?? 0),
            'asset_status' => trim((string)($_GET['asset_status'] ?? '')),
            'location_id' => (int)($_GET['location_id'] ?? 0),
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = max(1, min(100, (int)($_GET['per_page'] ?? 10)));
        $offset = ($page - 1) * $perPage;

        $assets = $assetModel->all($search, $filters, $perPage, $offset);
        $total = $assetModel->count($search, $filters);

        $lookup = $assetModel->lookupData();

        View::render('asset/index', [
            'title' => 'Asset Management',
            'user' => Session::get('auth'),
            'assets' => $assets,
            'assetCount' => $total,
            'search' => $search,
            'filters' => $filters,
            'categories' => $lookup['categories'],
            'locations' => $lookup['locations'],
            'pagination' => null,
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error'),
        ]);
    }

    public function create(): void
    {
        AuthMiddleware::handle();

        $assetModel = new Asset();
        $lookup = $assetModel->lookupData();

        View::render('asset/create', [
            'title' => 'Register Asset',
            'user' => Session::get('auth'),
            'asset' => [],
            ...$lookup,
            'errors' => Session::getFlash('asset_errors'),
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::handle();

        $assetModel = new Asset();

        $data = $this->requestData();
        $errors = $this->validate($assetModel, $data);

        if (!empty($errors)) {
            Session::flash('asset_errors', $errors);
            header('Location: /assets/create');
            exit;
        }

        try {
            $assetModel->create($data);

            Session::flash('success', 'Asset registered successfully.');
            header('Location: /assets');
            exit;
        } catch (\Throwable $e) {
            Session::flash('error', 'Unable to register asset: ' . $e->getMessage());
            header('Location: /assets/create');
            exit;
        }
    }

    public function edit(): void
    {
        AuthMiddleware::handle();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Invalid asset ID.');
            header('Location: /assets');
            exit;
        }

        $assetModel = new Asset();
        $asset = $assetModel->find($id);

        if (!$asset) {
            Session::flash('error', 'Asset not found.');
            header('Location: /assets');
            exit;
        }

        if (($asset['asset_status'] ?? '') === 'Disposed') {
            Session::flash('error', 'Disposed assets cannot be edited through the normal asset edit process.');
            header('Location: /assets/view?id=' . $id);
            exit;
        }

        $lookup = $assetModel->lookupData();

        View::render('asset/edit', [
            'title' => 'Edit Asset',
            'user' => Session::get('auth'),
            'asset' => $asset,
            ...$lookup,
            'errors' => Session::getFlash('asset_errors'),
        ]);
    }

    public function update(): void
    {
        AuthMiddleware::handle();

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Invalid asset ID.');
            header('Location: /assets');
            exit;
        }

        $assetModel = new Asset();
        $existing = $assetModel->find($id);

        if (!$existing) {
            Session::flash('error', 'Asset not found.');
            header('Location: /assets');
            exit;
        }

        if (($existing['asset_status'] ?? '') === 'Disposed') {
            Session::flash('error', 'Disposed assets cannot be edited.');
            header('Location: /assets/view?id=' . $id);
            exit;
        }

        $data = $this->requestData($existing);
        $errors = $this->validate($assetModel, $data, $id);

        if (!empty($errors)) {
            Session::flash('asset_errors', $errors);
            header('Location: /assets/edit?id=' . $id);
            exit;
        }

        try {
            $assetModel->update($id, $data);

            Session::flash('success', 'Asset updated successfully.');
            header('Location: /assets/view?id=' . $id);
            exit;
        } catch (\Throwable $e) {
            Session::flash('error', 'Unable to update asset: ' . $e->getMessage());
            header('Location: /assets/edit?id=' . $id);
            exit;
        }
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        // Historical asset records must never be physically deleted.
        Session::flash('error', 'Physical deletion of asset records is not permitted.');
        header('Location: /assets');
        exit;
    }

    public function view(): void
    {
        AuthMiddleware::handle();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Invalid asset ID.');
            header('Location: /assets');
            exit;
        }

        $assetModel = new Asset();
        $asset = $assetModel->find($id);

        if (!$asset) {
            Session::flash('error', 'Asset not found.');
            header('Location: /assets');
            exit;
        }

        View::render('asset/view', [
            'title' => 'Asset Details',
            'user' => Session::get('auth'),
            'asset' => $asset,
        ]);
    }

    private function requestData(array $existing = []): array
    {
        $categoryId = (int)($_POST['category_id'] ?? ($existing['category_id'] ?? 0));

        $assetModel = new Asset();
        $hasSpecs = $categoryId > 0 && $assetModel->categorySupportsSpecs($categoryId);

        return [
            // Lifecycle-protected values are preserved during edit.
            'asset_tag' => trim((string)($_POST['asset_tag'] ?? ($existing['asset_tag'] ?? ''))),
            'finance_asset_code' => $this->nullableString($_POST['finance_asset_code'] ?? ($existing['finance_asset_code'] ?? null)),
            'asset_name' => trim((string)($_POST['asset_name'] ?? '')),
            'serial_number' => trim((string)($_POST['serial_number'] ?? '')),
            'category_id' => $categoryId,
            'brand_id' => (int)($_POST['brand_id'] ?? 0) ?: null,
            'model_id' => (int)($_POST['model_id'] ?? 0) ?: null,
            'manufacturer_id' => (int)($_POST['manufacturer_id'] ?? 0) ?: null,
            'supplier_id' => (int)($_POST['supplier_id'] ?? 0) ?: null,
            'company_id' => (int)($_POST['company_id'] ?? 0) ?: null,
            'branch_id' => (int)($_POST['branch_id'] ?? 0) ?: null,
            'department_id' => (int)($_POST['department_id'] ?? 0) ?: null,
            'section_id' => $existing['section_id'] ?? null,
            'location_id' => (int)($_POST['location_id'] ?? 0) ?: null,
            'assigned_employee_id' => $existing['assigned_employee_id'] ?? null,
            'purchase_date' => $this->nullableString($_POST['purchase_date'] ?? null),
            'purchase_cost' => $this->nullableString($_POST['purchase_cost'] ?? null),
            'warranty_start' => $this->nullableString($_POST['warranty_start'] ?? null),
            'warranty_end' => $this->nullableString($_POST['warranty_end'] ?? null),
            'invoice_number' => $this->nullableString($_POST['invoice_number'] ?? null),
            'purchase_order_no' => $this->nullableString($_POST['purchase_order_no'] ?? null),
            'barcode' => $this->nullableString($_POST['barcode'] ?? null),
            'qr_code' => $this->nullableString($_POST['qr_code'] ?? null),
            'asset_condition' => trim((string)($_POST['asset_condition'] ?? ($existing['asset_condition'] ?? 'New'))),
            'asset_status' => $existing['asset_status'] ?? 'In Stock',
            'remarks' => trim((string)($_POST['remarks'] ?? '')),
            'processor' => $hasSpecs ? $this->nullableString($_POST['processor'] ?? null) : null,
            'ram' => $hasSpecs ? $this->nullableString($_POST['ram'] ?? null) : null,
            'storage' => $hasSpecs ? $this->nullableString($_POST['storage'] ?? null) : null,
            'operating_system' => $hasSpecs ? $this->nullableString($_POST['operating_system'] ?? null) : null,
        ];
    }

    private function validate(Asset $assetModel, array $data, ?int $excludeId = null): array
    {
        $errors = [];

        if ($data['asset_tag'] === '') {
            $errors[] = 'Asset Tag is required.';
        } elseif ($assetModel->existsAssetTag($data['asset_tag'], $excludeId)) {
            $errors[] = 'Asset Tag already exists.';
        }

        if ($data['asset_name'] === '') {
            $errors[] = 'Asset Name is required.';
        }

        if ($data['category_id'] <= 0) {
            $errors[] = 'Category is required.';
        }

        if ($data['company_id'] === null) {
            $errors[] = 'Company is required.';
        }

        if ($data['branch_id'] === null) {
            $errors[] = 'Branch is required.';
        }

        if ($data['department_id'] === null) {
            $errors[] = 'Department is required.';
        }

        if ($data['serial_number'] !== '' &&
            $assetModel->existsSerialNumber($data['serial_number'], $excludeId)) {
            $errors[] = 'Serial Number already belongs to another asset.';
        }

        if ($data['purchase_cost'] !== null && !is_numeric($data['purchase_cost'])) {
            $errors[] = 'Purchase Cost must be a valid number.';
        }

        return $errors;
    }

    private function nullableString(mixed $value): ?string
    {
        $value = trim((string)($value ?? ''));
        return $value === '' ? null : $value;
    }
}
