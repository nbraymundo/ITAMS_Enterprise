<div class="container-fluid py-4">

    <h2 class="mb-4">

        Edit Asset Category

    </h2>

    <form
        method="POST"
        action="/admin/asset-categories/update">

        <input
            type="hidden"
            name="id"
            value="<?= $category['id'] ?>">

        <?php
        require __DIR__ . '/form.php';
        ?>

        <div class="mt-4">

            <button
                class="btn btn-warning">

                Update

            </button>

            <a
                href="/admin/asset-categories"
                class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>