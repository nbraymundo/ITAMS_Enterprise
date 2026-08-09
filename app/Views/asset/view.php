<?php

declare(strict_types=1);

$asset = $asset ?? [];

function assetViewValue(mixed $value): string
{
    if ($value === null || $value === '') {
        return '<span class="text-muted">—</span>';
    }

    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

function assetStatusBadge(?string $status): string
{
    return match ($status) {
        'In Stock' =>
            '<span class="badge bg-info text-dark">In Stock</span>',

        'Assigned' =>
            '<span class="badge bg-success">Assigned</span>',

        'Maintenance' =>
            '<span class="badge bg-warning text-dark">Maintenance</span>',

        'Repair' =>
            '<span class="badge bg-warning text-dark">Repair</span>',

        'Disposed' =>
            '<span class="badge bg-danger">Disposed</span>',

        'Lost' =>
            '<span class="badge bg-dark">Lost</span>',

        default =>
            '<span class="badge bg-secondary">'
            . htmlspecialchars(
                (string) ($status ?: 'Unknown'),
                ENT_QUOTES,
                'UTF-8'
            )
            . '</span>'
    };
}

function conditionBadge(?string $condition): string
{
    return match ($condition) {
        'New' =>
            '<span class="badge bg-success">New</span>',

        'Good' =>
            '<span class="badge bg-primary">Good</span>',

        'Fair' =>
            '<span class="badge bg-warning text-dark">Fair</span>',

        'Poor' =>
            '<span class="badge bg-danger">Poor</span>',

        'Damaged',
        'Defective' =>
            '<span class="badge bg-dark">'
            . htmlspecialchars(
                (string) $condition,
                ENT_QUOTES,
                'UTF-8'
            )
            . '</span>',

        default =>
            '<span class="badge bg-secondary">'
            . htmlspecialchars(
                (string) ($condition ?: 'Unknown'),
                ENT_QUOTES,
                'UTF-8'
            )
            . '</span>'
    };
}
?>

<div class="container-fluid py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-laptop me-2"></i>
                Asset Details
            </h2>

            <p class="text-muted mb-0">
                <?= assetViewValue($asset['asset_tag'] ?? null) ?>
                —
                <?= assetViewValue($asset['asset_name'] ?? null) ?>
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="/assets"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-arrow-left me-2"></i>
                Back to Assets
            </a>

            <a
                href="/assets/edit?id=<?= (int) $asset['id'] ?>"
                class="btn btn-warning"
            >
                <i class="bi bi-pencil me-2"></i>
                Edit Asset
            </a>

            <?php if (
                empty($asset['assigned_employee_id'])
                && ($asset['asset_status'] ?? '') === 'In Stock'
            ): ?>

                <a
                    href="/assets/assign?id=<?= (int) $asset['id'] ?>"
                    class="btn btn-success"
                >
                    <i class="bi bi-person-plus me-2"></i>
                    Assign Asset
                </a>

            <?php endif; ?>

        </div>

    </div>


    <!-- STATUS SUMMARY -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <div class="d-flex align-items-center">

                        <div class="bg-light rounded p-3 me-3">
                            <i class="bi bi-laptop fs-2 text-primary"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Asset Tag
                            </div>

                            <div class="fs-4 fw-bold">
                                <?= assetViewValue(
                                    $asset['asset_tag'] ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="text-muted small">
                        Asset Status
                    </div>

                    <div class="mt-1">
                        <?= assetStatusBadge(
                            $asset['asset_status'] ?? null
                        ) ?>
                    </div>

                </div>


                <div class="col-md-3">

                    <div class="text-muted small">
                        Condition
                    </div>

                    <div class="mt-1">
                        <?= conditionBadge(
                            $asset['asset_condition'] ?? null
                        ) ?>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="row g-4">

        <!-- =====================================================
             IDENTIFICATION
        ====================================================== -->

        <div class="col-xl-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-upc-scan me-2 text-primary"></i>
                        Asset Identification
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Asset Tag
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['asset_tag'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Finance Asset Code
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['finance_asset_code'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Asset Name
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['asset_name'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Serial Number
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['serial_number'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Barcode
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['barcode'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                QR Code
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['qr_code'] ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             CLASSIFICATION
        ====================================================== -->

        <div class="col-xl-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-tags me-2 text-primary"></i>
                        Classification
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Category
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['category_name']
                                    ?? $asset['category']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Brand
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['brand_name']
                                    ?? $asset['brand']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Model
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['model_name']
                                    ?? $asset['model']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Manufacturer
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['manufacturer_name']
                                    ?? $asset['manufacturer']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-12">

                            <div class="text-muted small">
                                Supplier
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['supplier_name']
                                    ?? $asset['supplier']
                                    ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             COMPUTER SPECIFICATIONS
        ====================================================== -->

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-cpu me-2 text-primary"></i>
                        Computer Specifications
                    </h5>

                    <small class="text-muted">
                        Base specifications recorded when the asset
                        was registered.
                    </small>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-lg-3 col-md-6">

                            <div class="text-muted small">
                                Processor
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['processor'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="text-muted small">
                                RAM
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['ram'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="text-muted small">
                                Storage
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['storage'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="text-muted small">
                                Operating System
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['operating_system'] ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             ORGANIZATION / LOCATION
        ====================================================== -->

        <div class="col-xl-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-diagram-3 me-2 text-primary"></i>
                        Organization & Location
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="text-muted small">
                                Company
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['company_name']
                                    ?? $asset['company']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Branch
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['branch_name']
                                    ?? $asset['branch']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Department
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['department_name']
                                    ?? $asset['department']
                                    ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Location
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['location_name']
                                    ?? $asset['location']
                                    ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             CURRENT ASSIGNMENT
        ====================================================== -->

        <div class="col-xl-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-check me-2 text-success"></i>
                        Current Assignment
                    </h5>

                </div>

                <div class="card-body">

                    <?php if (
                        !empty($asset['assigned_employee_id'])
                        && !empty($asset['assigned_employee_name'])
                    ): ?>

                        <div class="d-flex align-items-center">

                            <div class="bg-success-subtle rounded-circle p-3 me-3">

                                <i class="bi bi-person-check fs-3 text-success"></i>

                            </div>

                            <div>

                                <div class="text-muted small">
                                    Assigned To
                                </div>

                                <div class="fs-5 fw-bold">
                                    <?= assetViewValue(
                                        $asset['assigned_employee_name']
                                    ) ?>
                                </div>

                                <?php if (!empty(
                                    $asset['assigned_employee_no']
                                )): ?>

                                    <div class="text-muted">
                                        Employee No:
                                        <?= assetViewValue(
                                            $asset['assigned_employee_no']
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php else: ?>

                        <div class="text-center py-4">

                            <i class="bi bi-person-x fs-1 text-muted"></i>

                            <div class="fw-semibold mt-2">
                                Not Assigned
                            </div>

                            <div class="text-muted small">
                                This asset is currently available.
                            </div>

                            <?php if (
                                ($asset['asset_status'] ?? '') === 'In Stock'
                            ): ?>

                                <a
                                    href="/assets/assign?id=<?= (int) $asset['id'] ?>"
                                    class="btn btn-success mt-3"
                                >
                                    <i class="bi bi-person-plus me-2"></i>
                                    Assign Asset
                                </a>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>


        <!-- =====================================================
             PURCHASE / WARRANTY
        ====================================================== -->

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        Purchase & Warranty
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-3">

                            <div class="text-muted small">
                                Purchase Date
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['purchase_date'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Purchase Cost
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['purchase_cost'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Warranty Start
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['warranty_start'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-3">

                            <div class="text-muted small">
                                Warranty End
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['warranty_end'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Invoice Number
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['invoice_number'] ?? null
                                ) ?>
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="text-muted small">
                                Purchase Order
                            </div>

                            <div class="fw-semibold">
                                <?= assetViewValue(
                                    $asset['purchase_order_no'] ?? null
                                ) ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             REMARKS
        ====================================================== -->

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-chat-left-text me-2 text-primary"></i>
                        Remarks
                    </h5>

                </div>

                <div class="card-body">

                    <?php if (!empty($asset['remarks'])): ?>

                        <div class="text-wrap">
                            <?= nl2br(
                                htmlspecialchars(
                                    $asset['remarks'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ) ?>
                        </div>

                    <?php else: ?>

                        <span class="text-muted">
                            No remarks.
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>