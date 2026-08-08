<?php

declare(strict_types=1);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Edit Asset Model</h2>

        <p class="text-muted">

            Update asset model information.

        </p>

    </div>

    <a
        href="/admin/models"
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


<form
    method="POST"
    action="/admin/models/update">

    <input
        type="hidden"
        name="id"
        value="<?= (int) $model['id'] ?>">

    <?php require __DIR__ . '/form.php'; ?>

</form>