<?php

declare(strict_types=1);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Add Asset Model</h2>

        <p class="text-muted">

            Create a new asset model.

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
    action="/admin/models">

    <?php require __DIR__ . '/form.php'; ?>

</form>