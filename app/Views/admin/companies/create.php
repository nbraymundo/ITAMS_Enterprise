<?php

declare(strict_types=1);

$company = $company ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Add Company</h2>

        <p class="text-muted mb-0">
            Create a new company.
        </p>

    </div>

    <a
        href="/admin/companies"
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


<div class="card">

    <div class="card-body">

        <form
            method="POST"
            action="/admin/companies">

            <?php require __DIR__ . '/form.php'; ?>

            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Save

                </button>

                <a
                    href="/admin/companies"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>