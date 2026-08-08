<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Asset Models</h2>

        <p class="text-muted">

            Manage Asset Models

        </p>

    </div>

    <a
        href="/admin/models/create"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Add Model

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

<div class="card shadow-sm">

    <div class="card-body border-bottom">

        <form
            method="GET"
            action="/admin/models"
            class="row g-3">

            <div class="col-md-4">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search model..."
                    value="<?= htmlspecialchars($search ?? '') ?>">

            </div>

            <div class="col-auto">

                <button class="btn btn-primary">

                    <i class="bi bi-search"></i>

                    Search

                </button>

            </div>

            <div class="col-auto">

                <a
                    href="/admin/models"
                    class="btn btn-secondary">

                    Reset

                </a>

            </div>

        </form>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="120">Code</th>

                    <th>Model</th>

                    <th>Brand</th>

                    <th>Manufacturer</th>

                    <th width="110">Status</th>

                    <th width="170">Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php if (empty($models)): ?>

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="bi bi-laptop display-4 text-secondary"></i>

                        <h5 class="mt-3">

                            No Asset Models Found

                        </h5>

                        <p class="text-muted">

                            Click "Add Model" to create your first asset model.

                        </p>

                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($models as $model): ?>

                    <tr>

                        <td><?= htmlspecialchars($model['model_code']) ?></td>

                        <td><?= htmlspecialchars($model['model_name']) ?></td>

                        <td><?= htmlspecialchars($model['brand_name']) ?></td>

                        <td><?= htmlspecialchars($model['manufacturer_name']) ?></td>

                        <td>

                            <span class="badge bg-<?= $model['status'] === 'Active' ? 'success' : 'secondary' ?>">

                                <?= htmlspecialchars($model['status']) ?>

                            </span>

                        </td>

                        <td>

                            <a
                                href="/admin/models/edit?id=<?= $model['id'] ?>"
                                class="btn btn-warning btn-sm">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <form
                                method="POST"
                                action="/admin/models/deactivate"
                                class="d-inline">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $model['id'] ?>">

                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Deactivate this model?')">

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

<?php if (isset($pagination) && $pagination->totalPages() > 1): ?>

<div class="mt-3">

    <nav>

        <ul class="pagination justify-content-end">

            <?php for ($i = 1; $i <= $pagination->totalPages(); $i++): ?>

                <li class="page-item <?= $pagination->currentPage() == $i ? 'active' : '' ?>">

                    <a
                        class="page-link"
                        href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>">

                        <?= $i ?>

                    </a>

                </li>

            <?php endfor; ?>

        </ul>

    </nav>

</div>

<?php endif; ?>