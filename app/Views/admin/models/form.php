<div class="card shadow-sm">

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">
                Model Code
            </label>

            <input
                type="text"
                name="model_code"
                class="form-control"
                maxlength="50"
                required
                value="<?= htmlspecialchars($model['model_code'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Model Name
            </label>

            <input
                type="text"
                name="model_name"
                class="form-control"
                maxlength="150"
                required
                value="<?= htmlspecialchars($model['model_name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Brand
            </label>

            <select
                name="brand_id"
                class="form-select"
                required>

                <option value="">
                    -- Select Brand --
                </option>

                <?php foreach ($brands as $brand): ?>

                    <option
                        value="<?= $brand['id'] ?>"
                        <?= (($model['brand_id'] ?? '') == $brand['id']) ? 'selected' : '' ?>>

                        <?= htmlspecialchars(
                            $brand['manufacturer_name']
                            . ' - '
                            . $brand['brand_name']
                        ) ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Description
            </label>

            <textarea
                name="description"
                rows="4"
                class="form-control"><?= htmlspecialchars($model['description'] ?? '') ?></textarea>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Status
            </label>

            <select
                name="status"
                class="form-select">

                <option
                    value="Active"
                    <?= (($model['status'] ?? 'Active') == 'Active') ? 'selected' : '' ?>>
                    Active
                </option>

                <option
                    value="Inactive"
                    <?= (($model['status'] ?? '') == 'Inactive') ? 'selected' : '' ?>>
                    Inactive
                </option>

            </select>

        </div>

        <button
            class="btn btn-primary">

            <i class="fa fa-save"></i>

            Save
        </button>

        <a
            href="/admin/models"
            class="btn btn-secondary">

            Cancel

        </a>

    </div>

</div>