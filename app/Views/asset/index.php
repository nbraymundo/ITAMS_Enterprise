<?php

declare(strict_types=1);

$assets = $assets ?? [];
$search = $search ?? '';
$filters = $filters ?? [];
$categories = $categories ?? [];
$locations = $locations ?? [];
$pagination = $pagination ?? null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Asset Inventory</h2>
        <p class="text-muted mb-0">Permanent inventory of registered IT assets.</p>
    </div>
    <a href="/assets/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Register Asset
    </a>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="/assets" class="row g-3">
            <div class="col-lg-5">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Asset tag, name, serial, brand, model..." value="<?= htmlspecialchars($search) ?>">
            </div>

            <div class="col-lg-2">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $row): ?>
                        <option value="<?= (int)$row['id'] ?>" <?= (string)($filters['category_id'] ?? '') === (string)$row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-2">
                <label class="form-label">Status</label>
                <select name="asset_status" class="form-select">
                    <option value="">All Statuses</option>
                    <?php foreach (['Available','Assigned','Maintenance','Repair','Disposed','Lost'] as $status): ?>
                        <option value="<?= $status ?>" <?= ($filters['asset_status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-2">
                <label class="form-label">Location</label>
                <select name="location_id" class="form-select">
                    <option value="">All Locations</option>
                    <?php foreach ($locations as $row): ?>
                        <option value="<?= (int)$row['id'] ?>" <?= (string)($filters['location_id'] ?? '') === (string)$row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['location_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-1 d-flex align-items-end">
                <button class="btn btn-primary w-100" type="submit" title="Apply filters">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Registered Assets</strong>
        <span class="text-muted small"><?= number_format($assetCount) ?> asset<?= $assetCount === 1 ? '' : 's' ?></span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Asset Tag</th>
                    <th>Asset</th>
                    <th>Category</th>
                    <th>Brand / Model</th>
                    <th>Serial No.</th>
                    <th>Status</th>
                    <th>Custodian</th>
                    <th>Location</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($assets)): ?>
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        No assets found.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($assets as $asset): ?>
                    <?php
                    $status = $asset['asset_status'] ?? 'Available';
                    $statusClass = match ($status) {
                        'Available' => 'success',
                        'Assigned' => 'primary',
                        'Maintenance' => 'warning',
                        'Repair' => 'info',
                        'Disposed', 'Lost' => 'danger',
                        default => 'secondary'
                    };
                    ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($asset['asset_tag']) ?></td>
                        <td>
                            <div><?= htmlspecialchars($asset['asset_name']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($asset['manufacturer_name'] ?? '-') ?></small>
                        </td>
                        <td><?= htmlspecialchars($asset['category_name'] ?? '-') ?></td>
                        <td>
                            <?= htmlspecialchars($asset['brand_name'] ?? '-') ?>
                            <br>
                            <small class="text-muted"><?= htmlspecialchars($asset['model_name'] ?? '-') ?></small>
                        </td>
                        <td><?= htmlspecialchars($asset['serial_number'] ?? '-') ?></td>
                        <td><span class="badge bg-<?= $statusClass ?>"><?= htmlspecialchars($status) ?></span></td>
                        <td><?= htmlspecialchars($asset['assigned_employee_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($asset['location_name'] ?? '-') ?></td>
                        <td class="text-center text-nowrap">
                            <a href="/assets/view?id=<?= (int)$asset['id'] ?>" class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/assets/edit?id=<?= (int)$asset['id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <?php if ($status === 'Available'): ?>
                                <button type="button" class="btn btn-sm btn-outline-success" disabled title="Assignment module is next">
                                    <i class="bi bi-person-check"></i>
                                </button>
                            <?php elseif ($status === 'Assigned'): ?>
                                <button type="button" class="btn btn-sm btn-outline-info" disabled title="Transfer module is next">
                                    <i class="bi bi-arrow-left-right"></i>
                                </button>
                            <?php endif; ?>
                            <?php if ($status !== 'Disposed'): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" disabled title="Disposal module is next">
                                    <i class="bi bi-recycle"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($pagination && $pagination->totalPages() > 1): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">Page <?= $pagination->currentPage() ?> of <?= $pagination->totalPages() ?></small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item <?= !$pagination->hasPrevious() ? 'disabled' : '' ?>">
                        <?php if ($pagination->hasPrevious()): ?>
                            <a class="page-link" href="/assets?page=<?= $pagination->previousPage() ?>&per_page=<?= $pagination->perPage() ?>&search=<?= urlencode($search) ?>&category_id=<?= urlencode((string)($filters['category_id'] ?? '')) ?>&asset_status=<?= urlencode((string)($filters['asset_status'] ?? '')) ?>&location_id=<?= urlencode((string)($filters['location_id'] ?? '')) ?>">Previous</a>
                        <?php else: ?>
                            <span class="page-link">Previous</span>
                        <?php endif; ?>
                    </li>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                    <li class="page-item <?= !$pagination->hasNext() ? 'disabled' : '' ?>">
                        <?php if ($pagination->hasNext()): ?>
                            <a class="page-link" href="/assets?page=<?= $pagination->nextPage() ?>&per_page=<?= $pagination->perPage() ?>&search=<?= urlencode($search) ?>&category_id=<?= urlencode((string)($filters['category_id'] ?? '')) ?>&asset_status=<?= urlencode((string)($filters['asset_status'] ?? '')) ?>&location_id=<?= urlencode((string)($filters['location_id'] ?? '')) ?>">Next</a>
                        <?php else: ?>
                            <span class="page-link">Next</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>
