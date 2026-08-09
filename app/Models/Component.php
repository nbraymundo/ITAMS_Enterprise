<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Component
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Get all components.
     */
    public function all(
        string $search = '',
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $sql = "
            SELECT
                c.*,
                s.supplier_name
            FROM components c

            LEFT JOIN suppliers s
                ON s.id = c.supplier_id

            WHERE 1 = 1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    c.component_code LIKE ?
                    OR c.component_name LIKE ?
                    OR c.component_type LIKE ?
                    OR c.manufacturer LIKE ?
                    OR c.model LIKE ?
                    OR c.part_number LIKE ?
                    OR c.serial_number LIKE ?
                )
            ";

            $term = '%' . $search . '%';

            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        $sql .= "
            ORDER BY
                c.component_code ASC
        ";

        if ($limit !== null) {
            $sql .= " LIMIT ?";

            $params[] = $limit;

            if ($offset !== null) {
                $sql .= " OFFSET ?";

                $params[] = $offset;
            }
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue(
                    $key + 1,
                    $value,
                    PDO::PARAM_INT
                );
            } else {
                $stmt->bindValue(
                    $key + 1,
                    $value,
                    PDO::PARAM_STR
                );
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count components.
     */
    public function count(
        string $search = ''
    ): int {
        $sql = "
            SELECT COUNT(*)
            FROM components c

            WHERE 1 = 1
        ";

        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    c.component_code LIKE ?
                    OR c.component_name LIKE ?
                    OR c.component_type LIKE ?
                    OR c.manufacturer LIKE ?
                    OR c.model LIKE ?
                    OR c.part_number LIKE ?
                    OR c.serial_number LIKE ?
                )
            ";

            $term = '%' . $search . '%';

            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        $stmt = $this->db->prepare($sql);

        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Find component by ID.
     */
    public function find(
        int $id
    ): ?array {
        $stmt = $this->db->prepare("
            SELECT
                c.*,
                s.supplier_name
            FROM components c

            LEFT JOIN suppliers s
                ON s.id = c.supplier_id

            WHERE c.id = ?

            LIMIT 1
        ");

        $stmt->execute([$id]);

        $component = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return $component ?: null;
    }

    /**
     * Find component by code.
     */
    public function findByCode(
        string $code
    ): ?array {
        $stmt = $this->db->prepare("
            SELECT *
            FROM components
            WHERE component_code = ?
            LIMIT 1
        ");

        $stmt->execute([$code]);

        $component = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return $component ?: null;
    }

    /**
     * Find component by serial number.
     */
    public function findBySerialNumber(
        string $serialNumber
    ): ?array {
        if ($serialNumber === '') {
            return null;
        }

        $stmt = $this->db->prepare("
            SELECT *
            FROM components
            WHERE serial_number = ?
            LIMIT 1
        ");

        $stmt->execute([
            $serialNumber
        ]);

        $component = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return $component ?: null;
    }

    /**
     * Create component.
     */
    public function create(
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            INSERT INTO components
            (
                component_code,
                component_type,
                component_name,
                manufacturer,
                model,
                part_number,
                serial_number,
                capacity,
                specification,
                supplier_id,
                purchase_date,
                purchase_cost,
                warranty_start,
                warranty_end,
                component_condition,
                status,
                quantity,
                remarks
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ");

        return $stmt->execute([
            $data['component_code'],
            $data['component_type'],
            $data['component_name'],

            $data['manufacturer'] ?? null,
            $data['model'] ?? null,
            $data['part_number'] ?? null,
            $data['serial_number'] ?? null,

            $data['capacity'] ?? null,
            $data['specification'] ?? null,

            $this->nullableInt(
                $data['supplier_id'] ?? null
            ),

            $data['purchase_date'] ?? null,
            $data['purchase_cost'] ?? null,

            $data['warranty_start'] ?? null,
            $data['warranty_end'] ?? null,

            $data['component_condition']
                ?? 'New',

            $data['status']
                ?? 'Available',

            (int) (
                $data['quantity']
                ?? 1
            ),

            $data['remarks'] ?? null
        ]);
    }

    /**
     * Update component.
     */
    public function update(
        int $id,
        array $data
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE components

            SET
                component_code = ?,
                component_type = ?,
                component_name = ?,

                manufacturer = ?,
                model = ?,
                part_number = ?,
                serial_number = ?,

                capacity = ?,
                specification = ?,

                supplier_id = ?,

                purchase_date = ?,
                purchase_cost = ?,

                warranty_start = ?,
                warranty_end = ?,

                component_condition = ?,
                status = ?,
                quantity = ?,

                remarks = ?

            WHERE id = ?
        ");

        return $stmt->execute([
            $data['component_code'],
            $data['component_type'],
            $data['component_name'],

            $data['manufacturer'] ?? null,
            $data['model'] ?? null,
            $data['part_number'] ?? null,
            $data['serial_number'] ?? null,

            $data['capacity'] ?? null,
            $data['specification'] ?? null,

            $this->nullableInt(
                $data['supplier_id'] ?? null
            ),

            $data['purchase_date'] ?? null,
            $data['purchase_cost'] ?? null,

            $data['warranty_start'] ?? null,
            $data['warranty_end'] ?? null,

            $data['component_condition']
                ?? 'New',

            $data['status']
                ?? 'Available',

            (int) (
                $data['quantity']
                ?? 1
            ),

            $data['remarks'] ?? null,

            $id
        ]);
    }

    /**
     * Deactivate / dispose component record.
     *
     * Historical records are not deleted.
     */
    public function deactivate(
        int $id
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE components

            SET status = 'Disposed'

            WHERE id = ?

            AND status <> 'Disposed'
        ");

        return $stmt->execute([$id]);
    }

    /**
     * Get suppliers.
     */
    public function suppliers(): array
    {
        $stmt = $this->db->query("
            SELECT
                id,
                supplier_code,
                supplier_name

            FROM suppliers

            WHERE status = 'Active'

            ORDER BY
                supplier_name ASC
        ");

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get currently installed asset for a component.
     */
    public function installedAsset(
        int $componentId
    ): ?array {
        $stmt = $this->db->prepare("
            SELECT
                ac.*,

                a.asset_tag,
                a.asset_name,
                a.serial_number

            FROM asset_components ac

            INNER JOIN assets a
                ON a.id = ac.asset_id

            WHERE ac.component_id = ?

            AND ac.status = 'Installed'

            ORDER BY
                ac.installed_date DESC,
                ac.id DESC

            LIMIT 1
        ");

        $stmt->execute([
            $componentId
        ]);

        $asset = $stmt->fetch(
            PDO::FETCH_ASSOC
        );

        return $asset ?: null;
    }

    /**
     * Get component installation history.
     */
    public function installationHistory(
        int $componentId
    ): array {
        $stmt = $this->db->prepare("
            SELECT
                ac.*,

                a.asset_tag,
                a.asset_name,
                a.serial_number

            FROM asset_components ac

            INNER JOIN assets a
                ON a.id = ac.asset_id

            WHERE ac.component_id = ?

            ORDER BY
                ac.installed_date DESC,
                ac.id DESC
        ");

        $stmt->execute([
            $componentId
        ]);

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Convert optional integer input to NULL.
     */
    private function nullableInt(
        mixed $value
    ): ?int {
        if (
            $value === null ||
            $value === ''
        ) {
            return null;
        }

        return (int) $value;
    }
}