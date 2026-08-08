<?php

declare(strict_types=1);
?>

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Asset Management
            </h2>

            <p class="text-muted mb-0">
                Manage and monitor all IT assets across the organization.
            </p>

        </div>

        <div>

            <a href="/assets/create" class="btn btn-primary">

                <i class="bi bi-plus-circle me-2"></i>

                Add Asset

            </a>

        </div>

    </div>

    <!-- Search & Filters -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-lg-4">

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search assets...">

                </div>

                <div class="col-lg-2">

                    <select class="form-select">

                        <option>Category</option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <select class="form-select">

                        <option>Status</option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <select class="form-select">

                        <option>Location</option>

                    </select>

                </div>

                <div class="col-lg-2 text-end">

                    <button class="btn btn-outline-secondary">

                        <i class="bi bi-download"></i>

                        Export

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Asset Table -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>Asset Tag</th>

                            <th>Asset Name</th>

                            <th>Category</th>

                            <th>Brand</th>

                            <th>Model</th>

                            <th>Serial No.</th>

                            <th>Status</th>

                            <th>Custodian</th>

                            <th>Location</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

<?php if (empty($assets)): ?>

    <tr>

        <td colspan="10" class="text-center py-5 text-muted">

            <i class="bi bi-inbox fs-1 d-block mb-3"></i>

            No assets found.

        </td>

    </tr>

<?php else: ?>

    <?php foreach ($assets as $asset): ?>

        <tr>

            <td><?= htmlspecialchars($asset['asset_tag']) ?></td>

            <td><?= htmlspecialchars($asset['asset_name']) ?></td>

            <td><?= htmlspecialchars($asset['category']) ?></td>

            <td><?= htmlspecialchars($asset['brand']) ?></td>

            <td><?= htmlspecialchars($asset['model']) ?></td>

            <td><?= htmlspecialchars($asset['serial_number']) ?></td>

            <td><?= htmlspecialchars($asset['status']) ?></td>

            <td><?= htmlspecialchars($asset['assigned_to'] ?? '-') ?></td>

            <td><?= htmlspecialchars($asset['location']) ?></td>

            <td>

                <button class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i>
                </button>

                <button class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </button>

            </td>

        </tr>

    <?php endforeach; ?>

<?php endif; ?>

</tbody>

                </table>

            </div>

        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center">

            <small class="text-muted">

                Showing <?= $assetCount ?> asset<?= $assetCount === 1 ? '' : 's' ?>

            </small>

            <nav>

                <ul class="pagination pagination-sm mb-0">

                    <li class="page-item disabled">

                        <a class="page-link">Previous</a>

                    </li>

                    <li class="page-item active">

                        <a class="page-link">1</a>

                    </li>

                    <li class="page-item disabled">

                        <a class="page-link">Next</a>

                    </li>

                </ul>

            </nav>

        </div>

    </div>

</div>