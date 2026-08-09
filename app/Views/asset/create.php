<?php

declare(strict_types=1);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Register Asset</h2>
        <p class="text-muted mb-0">
            Register a new IT asset into the permanent asset inventory.
        </p>
    </div>

    <a
        href="/assets"
        class="btn btn-secondary"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Back to Inventory
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <form
            method="POST"
            action="/assets"
        >
            <?php require __DIR__ . '/form.php'; ?>

            <div class="d-flex gap-2 mt-4 pt-3 border-top">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="bi bi-check-circle me-1"></i>
                    Register Asset
                </button>

                <a
                    href="/assets"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>

            </div>
        </form>

    </div>
</div>
