<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">

            Brand Code <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="brand_code"
            class="form-control"
            maxlength="30"
            required
            value="<?= htmlspecialchars($brand['brand_code'] ?? '') ?>">

    </div>

    <div class="col-md-8 mb-3">

        <label class="form-label">

            Brand Name <span class="text-danger">*</span>

        </label>

        <input
            type="text"
            name="brand_name"
            class="form-control"
            maxlength="150"
            required
            value="<?= htmlspecialchars($brand['brand_name'] ?? '') ?>">

    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Manufacturer <span class="text-danger">*</span>

        </label>

        <select
            name="manufacturer_id"
            class="form-select"
            required>

            <option value="">-- Select Manufacturer --</option>

            <?php foreach ($manufacturerList as $manufacturer): ?>

                <option
                    value="<?= $manufacturer['id'] ?>"
                    <?= (($brand['manufacturer_id'] ?? '') == $manufacturer['id']) ? 'selected' : '' ?>>

                    <?= htmlspecialchars($manufacturer['manufacturer_name']) ?>

                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">

            Status

        </label>

        <select
            name="status"
            class="form-select">

            <option
                value="Active"
                <?= (($brand['status'] ?? 'Active') === 'Active') ? 'selected' : '' ?>>

                Active

            </option>

            <option
                value="Inactive"
                <?= (($brand['status'] ?? '') === 'Inactive') ? 'selected' : '' ?>>

                Inactive

            </option>

        </select>

    </div>

</div>

<div class="mb-3">

    <label class="form-label">

        Description

    </label>

    <textarea
        name="description"
        class="form-control"
        rows="4"><?= htmlspecialchars($brand['description'] ?? '') ?></textarea>

</div>

<div class="mt-4">

    <button
        type="submit"
        class="btn btn-primary">

        <i class="bi bi-check-circle"></i>

        Save

    </button>

    <a
        href="/admin/brands"
        class="btn btn-secondary">

        Cancel

    </a>

</div>