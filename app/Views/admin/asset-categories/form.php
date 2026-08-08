<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Category Code</label>

        <input
            type="text"
            name="category_code"
            class="form-control"
            value="<?= htmlspecialchars($category['category_code'] ?? '') ?>"
            required>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">Category Name</label>

        <input
            type="text"
            name="category_name"
            class="form-control"
            value="<?= htmlspecialchars($category['category_name'] ?? '') ?>"
            required>

    </div>

</div>

<div class="mb-3">

    <label class="form-label">

        Description

    </label>

    <textarea
        class="form-control"
        rows="3"
        name="description"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>

</div>

<div class="row">

    <div class="col-md-4">

        <label class="form-label">

            Icon

        </label>

        <input
            class="form-control"
            name="icon"
            value="<?= htmlspecialchars($category['icon'] ?? '') ?>">

    </div>

    <div class="col-md-4">

        <label class="form-label">

            Color

        </label>

        <input
            class="form-control"
            name="color"
            value="<?= htmlspecialchars($category['color'] ?? '') ?>">

    </div>

    <div class="col-md-4">

        <label class="form-label">

            Sort Order

        </label>

        <input
            type="number"
            class="form-control"
            name="sort_order"
            value="<?= htmlspecialchars($category['sort_order'] ?? 0) ?>">

    </div>

</div>

<div class="mt-3">

    <label class="form-label">

        Status

    </label>

    <select
        name="status"
        class="form-select">

        <option
            value="Active"
            <?= (($category['status'] ?? 'Active') === 'Active') ? 'selected' : '' ?>>
            Active
        </option>

        <option
            value="Inactive"
            <?= (($category['status'] ?? '') === 'Inactive') ? 'selected' : '' ?>>
            Inactive
        </option>

    </select>

</div>