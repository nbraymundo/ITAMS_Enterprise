<?php

declare(strict_types=1);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Asset Categories</h2>
        <p class="text-muted mb-0">
            Manage Asset Categories
        </p>
    </div>

    <a
        href="/admin/asset-categories/create"
        class="btn btn-primary"
    >
        <i class="bi bi-plus-circle"></i>
        Add Category
    </a>
</div>

<?php if (!empty($success)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form
    method="GET"
    action="/admin/asset-categories"
    class="row g-2 mb-3"
>
    <input
        type="hidden"
        name="page"
        value="1"
    >

    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-search"></i>
            </span>

            <input
                type="text"
                class="form-control"
                name="search"
                placeholder="Search..."
                value="<?= htmlspecialchars($search ?? '') ?>"
            >
        </div>
    </div>

    <div class="col-auto">
        <select
            name="per_page"
            class="form-select"
            onchange="this.form.submit()"
        >
            <?php foreach ([10, 25, 50, 100] as $rows): ?>
                <option
                    value="<?= $rows ?>"
                    <?= $perPage == $rows ? 'selected' : '' ?>
                >
                    <?= $rows ?> Rows
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-auto">
        <button class="btn btn-primary">
            Search
        </button>
    </div>

    <div class="col-auto">
        <a
            href="/admin/asset-categories"
            class="btn btn-outline-secondary"
        >
            Reset
        </a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Device Specs</th>
                    <th>Assets</th>
                    <th>Status</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php if (empty($categories)): ?>

                <tr>
                    <td
                        colspan="7"
                        class="text-center py-5"
                    >
                        <i class="bi bi-folder2-open display-5 text-secondary"></i>

                        <h5 class="mt-3">
                            No Asset Categories
                        </h5>

                        <p class="text-muted">
                            No records found.
                        </p>
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach ($categories as $category): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $category['category_code']
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $category['category_name']
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $category['description'] ?? ''
                            ) ?>
                        </td>

                        <td>
                            <?php if (!empty($category['has_device_specs'])): ?>
                                <span class="badge bg-primary">
                                    Required
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    Not Required
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= (int) $category['total_assets'] ?>
                        </td>

                        <td>
                            <?php if ($category['status'] === 'Active'): ?>
                                <span class="badge bg-success">
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a
                                href="/admin/asset-categories/edit?id=<?= (int) $category['id'] ?>"
                                class="btn btn-warning btn-sm"
                                title="Edit"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form
                                method="POST"
                                action="/admin/asset-categories/deactivate"
                                class="d-inline"
                            >
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $category['id'] ?>"
                                >

                                <button
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Deactivate this category?')"
                                    title="Deactivate"
                                >
                                    <i class="bi bi-slash-circle"></i>
                                </button>
                            </form>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">

    <div>
        Showing
        <strong><?= count($categories) ?></strong>
        of
        <strong><?= $paginator->totalRecords() ?></strong>
        records
    </div>

    <nav>
        <ul class="pagination mb-0">

            <li
                class="page-item <?= $paginator->hasPrevious() ? '' : 'disabled' ?>"
            >
                <a
                    class="page-link"
                    href="?search=<?= urlencode($search) ?>&per_page=<?= $perPage ?>&page=<?= $paginator->previousPage() ?>"
                >
                    Previous
                </a>
            </li>

            <?php for (
                $i = 1;
                $i <= $paginator->totalPages();
                $i++
            ): ?>

                <li
                    class="page-item <?= $i == $paginator->currentPage() ? 'active' : '' ?>"
                >
                    <a
                        class="page-link"
                        href="?search=<?= urlencode($search) ?>&per_page=<?= $perPage ?>&page=<?= $i ?>"
                    >
                        <?= $i ?>
                    </a>
                </li>

            <?php endfor; ?>

            <li
                class="page-item <?= $paginator->hasNext() ? '' : 'disabled' ?>"
            >
                <a
                    class="page-link"
                    href="?search=<?= urlencode($search) ?>&per_page=<?= $perPage ?>&page=<?= $paginator->nextPage() ?>"
                >
                    Next
                </a>
            </li>

        </ul>
    </nav>

</div>
