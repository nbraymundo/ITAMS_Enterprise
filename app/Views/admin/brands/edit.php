<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Edit Asset Brand</h2>

        <p class="text-muted">

            Update asset brand information.

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
            action="/admin/brands/update">

            <input
                type="hidden"
                name="id"
                value="<?= (int)$brand['id'] ?>">

            <?php require __DIR__ . '/form.php'; ?>

        </form>

    </div>

</div>