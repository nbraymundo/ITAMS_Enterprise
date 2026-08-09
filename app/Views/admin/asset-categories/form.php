<?php

declare(strict_types=1);

$category = $category ?? [];

function categoryValue(mixed $value): string
{
    return htmlspecialchars(
        (string) ($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Category Code</label>

        <input
            type="text"
            name="category_code"
            class="form-control"
            value="<?= categoryValue($category['category_code'] ?? '') ?>"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Category Name</label>

        <input
            type="text"
            name="category_name"
            class="form-control"
            value="<?= categoryValue($category['category_name'] ?? '') ?>"
            required
        >
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>

    <textarea
        class="form-control"
        rows="3"
        name="description"
    ><?= categoryValue($category['description'] ?? '') ?></textarea>
</div>

<div class="card border-primary-subtle bg-primary-subtle mb-3">
    <div class="card-body">
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                name="has_device_specs"
                value="1"
                id="has_device_specs"
                <?= !empty($category['has_device_specs']) ? 'checked' : '' ?>
            >

            <label
                class="form-check-label fw-semibold"
                for="has_device_specs"
            >
                Require Device Specifications
            </label>
        </div>

        <div class="small text-muted mt-2">
            Enable this for asset categories that require:
            Processor, RAM, Storage / SSD and Operating System.
            Example: Laptop, Desktop Computer, Workstation.
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label class="form-label">Icon</label>

        <input
            class="form-control"
            name="icon"
            value="<?= categoryValue($category['icon'] ?? '') ?>"
        >
    </div>

    <div class="col-md-4">
        <label class="form-label">Color</label>

        <input
            class="form-control"
            name="color"
            value="<?= categoryValue($category['color'] ?? '') ?>"
        >
    </div>

    <div class="col-md-4">
        <label class="form-label">Sort Order</label>

        <input
            type="number"
            class="form-control"
            name="sort_order"
            min="0"
            value="<?= categoryValue($category['sort_order'] ?? 0) ?>"
        >
    </div>
</div>

<div class="mt-3">
    <label class="form-label">Status</label>

    <select
        name="status"
        class="form-select"
    >
        <option
            value="Active"
            <?= (($category['status'] ?? 'Active') === 'Active')
                ? 'selected'
                : '' ?>
        >
            Active
        </option>

        <option
            value="Inactive"
            <?= (($category['status'] ?? '') === 'Inactive')
                ? 'selected'
                : '' ?>
        >
            Inactive
        </option>
    </select>
</div>
