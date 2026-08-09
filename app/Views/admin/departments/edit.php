<div class="d-flex justify-content-between align-items-start mb-4">

    <div>

        <h2>Edit Department</h2>

        <p class="text-muted mb-0">
            Update department information.
        </p>

    </div>


    <a
        href="/admin/departments"
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
            action="/admin/departments/update">

            <input
                type="hidden"
                name="id"
                value="<?= (int) ($department['id'] ?? 0) ?>">


            <div class="row g-3">

                <?php require __DIR__ . '/form.php'; ?>

            </div>


            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>

                    Save

                </button>


                <a
                    href="/admin/departments"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>