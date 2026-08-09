<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Asset
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function all(
        string $search = '',
        array $filters = [],
        int $limit = 10,
        int $offset = 0
    ): array {
        $sql = "
            SELECT
                a.*,
                ac.category_code,
                ac.category_name,
                b.brand_name,
                am.model_name,
                m.manufacturer_name,
                s.supplier_name,
                c.company_name,
                br.branch_name,
                d.department_name,
                l.location_name,
                CONCAT_WS(' ', e.first_name, e.middle_name, e.last_name) AS assigned_employee_name
            FROM assets a
            LEFT JOIN asset_categories ac ON ac.id = a.category_id
            LEFT JOIN asset_brands b ON b.id = a.brand_id
            LEFT JOIN asset_models am ON am.id = a.model_id
            LEFT JOIN manufacturers m ON m.id = a.manufacturer_id
            LEFT JOIN suppliers s ON s.id = a.supplier_id
            LEFT JOIN companies c ON c.id = a.company_id
            LEFT JOIN branches br ON br.id = a.branch_id
            LEFT JOIN departments d ON d.id = a.department_id
            LEFT JOIN locations l ON l.id = a.location_id
            LEFT JOIN employees e ON e.id = a.assigned_employee_id
            WHERE 1 = 1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    a.asset_tag LIKE ?
                    OR a.asset_name LIKE ?
                    OR a.serial_number LIKE ?
                    OR a.barcode LIKE ?
                    OR ac.category_name LIKE ?
                    OR b.brand_name LIKE ?
                    OR am.model_name LIKE ?
                    OR m.manufacturer_name LIKE ?
                    OR c.company_name LIKE ?
                    OR br.branch_name LIKE ?
                    OR d.department_name LIKE ?
                    OR l.location_name LIKE ?
                    OR CONCAT_WS(' ', e.first_name, e.middle_name, e.last_name) LIKE ?
                )
            ";

            $term = '%' . $search . '%';

            for ($i = 0; $i < 13; $i++) {
                $params[] = $term;
            }
        }

        $this->appendFilters($sql, $params, $filters);

        $sql .= "
            ORDER BY a.id DESC
            LIMIT ? OFFSET ?
        ";

        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);

        foreach ($params as $index => $value) {
            $stmt->bindValue(
                $index + 1,
                $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(
        string $search = '',
        array $filters = []
    ): int {
        $sql = "
            SELECT COUNT(*)
            FROM assets a
            LEFT JOIN asset_categories ac ON ac.id = a.category_id
            LEFT JOIN asset_brands b ON b.id = a.brand_id
            LEFT JOIN asset_models am ON am.id = a.model_id
            LEFT JOIN manufacturers m ON m.id = a.manufacturer_id
            LEFT JOIN companies c ON c.id = a.company_id
            LEFT JOIN branches br ON br.id = a.branch_id
            LEFT JOIN departments d ON d.id = a.department_id
            LEFT JOIN locations l ON l.id = a.location_id
            LEFT JOIN employees e ON e.id = a.assigned_employee_id
            WHERE 1 = 1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    a.asset_tag LIKE ?
                    OR a.asset_name LIKE ?
                    OR a.serial_number LIKE ?
                    OR a.barcode LIKE ?
                    OR ac.category_name LIKE ?
                    OR b.brand_name LIKE ?
                    OR am.model_name LIKE ?
                    OR m.manufacturer_name LIKE ?
                    OR c.company_name LIKE ?
                    OR br.branch_name LIKE ?
                    OR d.department_name LIKE ?
                    OR l.location_name LIKE ?
                    OR CONCAT_WS(' ', e.first_name, e.middle_name, e.last_name) LIKE ?
                )
            ";

            $term = '%' . $search . '%';

            for ($i = 0; $i < 13; $i++) {
                $params[] = $term;
            }
        }

        $this->appendFilters($sql, $params, $filters);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                a.*,
                ac.category_code,
                ac.category_name,
                b.brand_name,
                am.model_name,
                m.manufacturer_name,
                s.supplier_name,
                c.company_name,
                br.branch_name,
                d.department_name,
                l.location_name,
                CONCAT_WS(' ', e.first_name, e.middle_name, e.last_name) AS assigned_employee_name
            FROM assets a
            LEFT JOIN asset_categories ac ON ac.id = a.category_id
            LEFT JOIN asset_brands b ON b.id = a.brand_id
            LEFT JOIN asset_models am ON am.id = a.model_id
            LEFT JOIN manufacturers m ON m.id = a.manufacturer_id
            LEFT JOIN suppliers s ON s.id = a.supplier_id
            LEFT JOIN companies c ON c.id = a.company_id
            LEFT JOIN branches br ON br.id = a.branch_id
            LEFT JOIN departments d ON d.id = a.department_id
            LEFT JOIN locations l ON l.id = a.location_id
            LEFT JOIN employees e ON e.id = a.assigned_employee_id
            WHERE a.id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existsAssetTag(
        string $assetTag,
        ?int $excludeId = null
    ): bool {
        $sql = 'SELECT COUNT(*) FROM assets WHERE asset_tag = ?';
        $params = [$assetTag];

        if ($excludeId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function existsSerialNumber(
        string $serialNumber,
        ?int $excludeId = null
    ): bool {
        if ($serialNumber === '') {
            return false;
        }

        $sql = 'SELECT COUNT(*) FROM assets WHERE serial_number = ?';
        $params = [$serialNumber];

        if ($excludeId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(array $data): bool
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
                INSERT INTO assets
                (
                    asset_tag, finance_asset_code, serial_number, asset_name,
                    category_id, brand_id, model_id, manufacturer_id, supplier_id,
                    company_id, branch_id, department_id, section_id, location_id,
                    assigned_employee_id, purchase_date, purchase_cost, warranty_start,
                    warranty_end, invoice_number, purchase_order_no, barcode, qr_code,
                    processor, ram, storage, operating_system, asset_condition,
                    asset_status, remarks
                )
                VALUES
                (
                    :asset_tag, :finance_asset_code, :serial_number, :asset_name,
                    :category_id, :brand_id, :model_id, :manufacturer_id, :supplier_id,
                    :company_id, :branch_id, :department_id, :section_id, :location_id,
                    :assigned_employee_id, :purchase_date, :purchase_cost, :warranty_start,
                    :warranty_end, :invoice_number, :purchase_order_no, :barcode, :qr_code,
                    :processor, :ram, :storage, :operating_system, :asset_condition,
                    :asset_status, :remarks
                )
            ");

            $stmt->execute([
                ':asset_tag' => $data['asset_tag'],
                ':finance_asset_code' => $this->nullableFinanceCode($data['finance_asset_code'] ?? null),
                ':serial_number' => $data['serial_number'] ?: null,
                ':asset_name' => $data['asset_name'],
                ':category_id' => $data['category_id'],
                ':brand_id' => $data['brand_id'],
                ':model_id' => $data['model_id'],
                ':manufacturer_id' => $data['manufacturer_id'],
                ':supplier_id' => $data['supplier_id'],
                ':company_id' => $data['company_id'],
                ':branch_id' => $data['branch_id'],
                ':department_id' => $data['department_id'],
                ':section_id' => $data['section_id'],
                ':location_id' => $data['location_id'],
                ':assigned_employee_id' => $data['assigned_employee_id'],
                ':purchase_date' => $data['purchase_date'],
                ':purchase_cost' => $data['purchase_cost'],
                ':warranty_start' => $data['warranty_start'],
                ':warranty_end' => $data['warranty_end'],
                ':invoice_number' => $data['invoice_number'],
                ':purchase_order_no' => $data['purchase_order_no'],
                ':barcode' => $data['barcode'],
                ':qr_code' => $data['qr_code'],
                ':processor' => $data['processor'] ?? null,
                ':ram' => $data['ram'] ?? null,
                ':storage' => $data['storage'] ?? null,
                ':operating_system' => $data['operating_system'] ?? null,
                ':asset_condition' => $data['asset_condition'],
                ':asset_status' => $data['asset_status'],
                ':remarks' => $data['remarks']
            ]);

            $id = (int)$this->db->lastInsertId();
            if ($id <= 0) {
                throw new \RuntimeException('Asset was inserted but no asset ID was returned.');
            }

            // Explicitly persist the Finance/ERP reference as a separate write.
            // This guarantees the field is saved even if an older schema/trigger
            // or legacy INSERT path interferes with the initial value.
            $finance = $this->nullableFinanceCode($data['finance_asset_code'] ?? null);
            $financeStmt = $this->db->prepare(
                'UPDATE assets SET finance_asset_code = :finance_asset_code WHERE id = :id'
            );
            $financeStmt->execute([
                ':finance_asset_code' => $finance,
                ':id' => $id
            ]);

            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function update(
        int $id,
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE assets
            SET
                asset_tag = :asset_tag,
                finance_asset_code = :finance_asset_code,
                serial_number = :serial_number,
                asset_name = :asset_name,
                category_id = :category_id,
                brand_id = :brand_id,
                model_id = :model_id,
                manufacturer_id = :manufacturer_id,
                supplier_id = :supplier_id,
                company_id = :company_id,
                branch_id = :branch_id,
                department_id = :department_id,
                section_id = :section_id,
                location_id = :location_id,
                assigned_employee_id = :assigned_employee_id,
                purchase_date = :purchase_date,
                purchase_cost = :purchase_cost,
                warranty_start = :warranty_start,
                warranty_end = :warranty_end,
                invoice_number = :invoice_number,
                purchase_order_no = :purchase_order_no,
                barcode = :barcode,
                qr_code = :qr_code,
                processor = :processor,
                ram = :ram,
                storage = :storage,
                operating_system = :operating_system,
                asset_condition = :asset_condition,
                asset_status = :asset_status,
                remarks = :remarks
            WHERE id = :id
        ");

        $finance = $this->nullableFinanceCode($data['finance_asset_code'] ?? null);
        $stmt->execute([
            ':asset_tag' => $data['asset_tag'],
            ':finance_asset_code' => $finance,
            ':serial_number' => $data['serial_number'] ?: null,
            ':asset_name' => $data['asset_name'],
            ':category_id' => $data['category_id'],
            ':brand_id' => $data['brand_id'],
            ':model_id' => $data['model_id'],
            ':manufacturer_id' => $data['manufacturer_id'],
            ':supplier_id' => $data['supplier_id'],
            ':company_id' => $data['company_id'],
            ':branch_id' => $data['branch_id'],
            ':department_id' => $data['department_id'],
            ':section_id' => $data['section_id'],
            ':location_id' => $data['location_id'],
            ':assigned_employee_id' => $data['assigned_employee_id'],
            ':purchase_date' => $data['purchase_date'],
            ':purchase_cost' => $data['purchase_cost'],
            ':warranty_start' => $data['warranty_start'],
            ':warranty_end' => $data['warranty_end'],
            ':invoice_number' => $data['invoice_number'],
            ':purchase_order_no' => $data['purchase_order_no'],
            ':barcode' => $data['barcode'],
            ':qr_code' => $data['qr_code'],
            ':processor' => $data['processor'] ?? null,
            ':ram' => $data['ram'] ?? null,
            ':storage' => $data['storage'] ?? null,
            ':operating_system' => $data['operating_system'] ?? null,
            ':asset_condition' => $data['asset_condition'],
            ':asset_status' => $data['asset_status'],
            ':remarks' => $data['remarks'],
            ':id' => $id
        ]);

        // Explicit second write for Finance/ERP reference.
        $financeStmt = $this->db->prepare(
            'UPDATE assets SET finance_asset_code = :finance_asset_code WHERE id = :id'
        );
        $financeStmt->execute([
            ':finance_asset_code' => $finance,
            ':id' => $id
        ]);

        return true;
    }

    private function nullableFinanceCode(mixed $value): ?string
    {
        $value = trim((string)($value ?? ''));
        return $value === '' ? null : $value;
    }

    public function categorySupportsSpecs(int $categoryId): bool
    {
        if ($categoryId <= 0) {
            return false;
        }

        $stmt = $this->db->prepare("
            SELECT has_device_specs
            FROM asset_categories
            WHERE id = ?
              AND status = 'Active'
            LIMIT 1
        ");

        $stmt->execute([$categoryId]);

        return (bool)$stmt->fetchColumn();
    }

    public function lookupData(): array
    {
        return [
            'categories' => $this->db->query("SELECT id, category_code, category_name, has_device_specs FROM asset_categories WHERE status = 'Active' ORDER BY category_name")->fetchAll(PDO::FETCH_ASSOC),
            'brands' => $this->db->query("SELECT id, brand_name FROM asset_brands WHERE status = 'Active' ORDER BY brand_name")->fetchAll(PDO::FETCH_ASSOC),
            'models' => $this->db->query("SELECT id, model_name FROM asset_models ORDER BY model_name")->fetchAll(PDO::FETCH_ASSOC),
            'manufacturers' => $this->db->query("SELECT id, manufacturer_name FROM manufacturers WHERE status = 'Active' ORDER BY manufacturer_name")->fetchAll(PDO::FETCH_ASSOC),
            'suppliers' => $this->db->query("SELECT id, supplier_code, supplier_name FROM suppliers WHERE status = 'Active' ORDER BY supplier_name")->fetchAll(PDO::FETCH_ASSOC),
            'companies' => $this->db->query("SELECT id, company_code, company_name FROM companies WHERE status = 'Active' ORDER BY company_name")->fetchAll(PDO::FETCH_ASSOC),
            'branches' => $this->db->query("SELECT id, company_id, branch_code, branch_name FROM branches WHERE status = 'Active' ORDER BY branch_name")->fetchAll(PDO::FETCH_ASSOC),
            'departments' => $this->db->query("SELECT id, department_code, department_name FROM departments WHERE status = 'Active' ORDER BY department_name")->fetchAll(PDO::FETCH_ASSOC),
            'locations' => $this->db->query("SELECT id, location_code, location_name FROM locations WHERE status = 'Active' ORDER BY location_name")->fetchAll(PDO::FETCH_ASSOC),
            'employees' => $this->db->query("SELECT id, employee_no, first_name, middle_name, last_name FROM employees WHERE employment_status = 'Active' ORDER BY last_name, first_name")->fetchAll(PDO::FETCH_ASSOC)
        ];
    }

    private function appendFilters(
        string &$sql,
        array &$params,
        array $filters
    ): void {
        if (!empty($filters['category_id'])) {
            $sql .= ' AND a.category_id = ?';
            $params[] = (int)$filters['category_id'];
        }

        if (!empty($filters['asset_status'])) {
            $sql .= ' AND a.asset_status = ?';
            $params[] = $filters['asset_status'];
        }

        if (!empty($filters['location_id'])) {
            $sql .= ' AND a.location_id = ?';
            $params[] = (int)$filters['location_id'];
        }
    }
}
