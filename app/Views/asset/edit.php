<?php

declare(strict_types=1);

$asset = $asset ?? [];
$errors = $errors ?? [];
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Asset
            </h2>
            <p class="text-muted mb-0">
                <?= htmlspecialchars($asset['asset_tag'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                —
                <?= htmlspecialchars($asset['asset_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>

        <a href="/assets/view?id=<?= (int)$asset['id'] ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Cancel
        </a>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Lifecycle protection:</strong>
        Asset Tag, assignment, and asset status are controlled by their respective lifecycle processes and cannot be changed here.
    </div>

    <form method="POST" action="/assets/update">
        <input type="hidden" name="id" value="<?= (int)$asset['id'] ?>">

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php require __DIR__ . '/form.php'; ?>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="/assets/view?id=<?= (int)$asset['id'] ?>" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
