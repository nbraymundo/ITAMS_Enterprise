<div class="container-fluid py-4">

    <h2 class="mb-4">

        Add Asset Category

    </h2>

    <form
        method="POST"
        action="/admin/asset-categories">

        <?php
        $category = [];
        require __DIR__ . '/form.php';
        ?>

        <div class="mt-4">

            <button
                class="btn btn-primary">

                Save

            </button>

            <a
                href="/admin/asset-categories"
                class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>