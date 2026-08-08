<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Add Asset Brand</h2>

        <p class="text-muted">

            Create a new asset brand.

        </p>

    </div>

    <a
        href="/admin/brands"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>

        Back

    </a>

</div>

<?php if (!empty($error)): ?>

    <div class="alert alert-danger">

        <?= htmlspecialchars($error) ?>

    </div>

<?php endif; ?>

<div class="card shadow-sm">

    <div class="card-body">

        <form
            method="POST"
            action="/admin/brands">

            <?php require __DIR__ . '/form.php'; ?>

        </form>

    </div>

</div>