<?php

declare(strict_types=1);

$asset = $asset ?? [];
$categories = $categories ?? [];
$brands = $brands ?? [];
$models = $models ?? [];
$manufacturers = $manufacturers ?? [];
$suppliers = $suppliers ?? [];
$companies = $companies ?? [];
$branches = $branches ?? [];
$departments = $departments ?? [];
$locations = $locations ?? [];
$errors = $errors ?? [];

$conditions = ['New', 'Good', 'Fair', 'Poor', 'Damaged'];

function assetFormValue(mixed $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <strong>Please correct the following:</strong>
    <ul class="mb-0 mt-2">
        <?php foreach ($errors as $error): ?>
            <li><?= assetFormValue($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="row g-4">

    <div class="col-12">
        <div class="border-bottom pb-2 mb-3">
            <h5 class="mb-0">Asset Identification</h5>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Asset Tag <span class="text-danger">*</span></label>
        <input type="text" name="asset_tag" class="form-control"
               required maxlength="50"
               value="<?= assetFormValue($asset['asset_tag'] ?? '') ?>"
               >
    </div>

    <div class="col-md-4">
        <label class="form-label">Finance Asset Code</label>
        <input type="text" name="finance_asset_code" class="form-control"
               maxlength="100"
               value="<?= assetFormValue($asset['finance_asset_code'] ?? '') ?>"
               placeholder="Finance / ERP asset reference">
    </div>

    <div class="col-md-4">
        <label class="form-label">Asset Name <span class="text-danger">*</span></label>
        <input type="text" name="asset_name" class="form-control"
               required maxlength="150"
               value="<?= assetFormValue($asset['asset_name'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Serial Number</label>
        <input type="text" name="serial_number" class="form-control"
               maxlength="100"
               value="<?= assetFormValue($asset['serial_number'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <select name="category_id" id="assetCategory" class="form-select" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $row): ?>
                <option
                    value="<?= (int)$row['id'] ?>"
                    data-device-specs="<?= (int)($row['has_device_specs'] ?? 0) ?>"
                    <?= (int)($asset['category_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Manufacturer</label>
        <select name="manufacturer_id" class="form-select">
            <option value="">-- Select Manufacturer --</option>
            <?php foreach ($manufacturers as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['manufacturer_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['manufacturer_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Brand <span class="text-danger">*</span></label>
        <select name="brand_id" class="form-select" required>
            <option value="">-- Select Brand --</option>
            <?php foreach ($brands as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['brand_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['brand_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Model <span class="text-danger">*</span></label>
        <select name="model_id" class="form-select" required>
            <option value="">-- Select Model --</option>
            <?php foreach ($models as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['model_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['model_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select">
            <option value="">-- Select Supplier --</option>
            <?php foreach ($suppliers as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['supplier_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['supplier_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- CATEGORY-DRIVEN DEVICE SPECIFICATIONS -->
    <div class="col-12" id="deviceSpecifications" style="display:none;">
        <div class="card border-0 bg-light">
            <div class="card-body">
                <div class="border-bottom pb-2 mb-3">
                    <h5 class="mb-0"><i class="bi bi-cpu me-2"></i>Device Specifications</h5>
                    <small class="text-muted">Displayed only for categories configured to require device specifications.</small>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Processor</label>
                        <input type="text" name="processor" class="form-control"
                               maxlength="255"
                               value="<?= assetFormValue($asset['processor'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">RAM</label>
                        <input type="text" name="ram" class="form-control"
                               maxlength="100"
                               value="<?= assetFormValue($asset['ram'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Storage</label>
                        <input type="text" name="storage" class="form-control"
                               maxlength="150"
                               value="<?= assetFormValue($asset['storage'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Operating System</label>
                        <input type="text" name="operating_system" class="form-control"
                               maxlength="150"
                               value="<?= assetFormValue($asset['operating_system'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-2">
        <div class="border-bottom pb-2 mb-3">
            <h5 class="mb-0">Organization & Location</h5>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Company <span class="text-danger">*</span></label>
        <select name="company_id" class="form-select" required>
            <option value="">-- Select Company --</option>
            <?php foreach ($companies as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['company_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['company_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Branch <span class="text-danger">*</span></label>
        <select name="branch_id" class="form-select" required>
            <option value="">-- Select Branch --</option>
            <?php foreach ($branches as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['branch_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['branch_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Department <span class="text-danger">*</span></label>
        <select name="department_id" class="form-select" required>
            <option value="">-- Select Department --</option>
            <?php foreach ($departments as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['department_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Location</label>
        <select name="location_id" class="form-select">
            <option value="">-- Select Location --</option>
            <?php foreach ($locations as $row): ?>
                <option value="<?= (int)$row['id'] ?>" <?= (int)($asset['location_id'] ?? 0) === (int)$row['id'] ? 'selected' : '' ?>>
                    <?= assetFormValue($row['location_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12 mt-2">
        <div class="border-bottom pb-2 mb-3">
            <h5 class="mb-0">Purchase & Warranty</h5>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Date</label>
        <input type="date" name="purchase_date" class="form-control"
               value="<?= assetFormValue($asset['purchase_date'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Cost</label>
        <input type="number" name="purchase_cost" class="form-control"
               min="0" step="0.01"
               value="<?= assetFormValue($asset['purchase_cost'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Invoice Number</label>
        <input type="text" name="invoice_number" class="form-control" maxlength="100"
               value="<?= assetFormValue($asset['invoice_number'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Order No.</label>
        <input type="text" name="purchase_order_no" class="form-control" maxlength="100"
               value="<?= assetFormValue($asset['purchase_order_no'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Warranty Start</label>
        <input type="date" name="warranty_start" class="form-control"
               value="<?= assetFormValue($asset['warranty_start'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Warranty End</label>
        <input type="date" name="warranty_end" class="form-control"
               value="<?= assetFormValue($asset['warranty_end'] ?? '') ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">Barcode</label>
        <input type="text" name="barcode" class="form-control" maxlength="100"
               value="<?= assetFormValue($asset['barcode'] ?? '') ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">QR Code</label>
        <input type="text" name="qr_code" class="form-control" maxlength="255"
               value="<?= assetFormValue($asset['qr_code'] ?? '') ?>">
    </div>

    <div class="col-12 mt-2">
        <div class="border-bottom pb-2 mb-3">
            <h5 class="mb-0">Condition & Remarks</h5>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Asset Condition</label>
        <select name="asset_condition" class="form-select">
            <?php foreach ($conditions as $value): ?>
                <option value="<?= assetFormValue($value) ?>"
                    <?= ($asset['asset_condition'] ?? 'New') === $value ? 'selected' : '' ?>>
                    <?= assetFormValue($value) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-8">
        <label class="form-label">Remarks</label>
        <textarea name="remarks" class="form-control" rows="3"><?= assetFormValue($asset['remarks'] ?? '') ?></textarea>
    </div>

</div>

<script>
(function () {
    const category = document.getElementById('assetCategory');
    const specs = document.getElementById('deviceSpecifications');

    function refreshDeviceSpecifications() {
        const option = category ? category.options[category.selectedIndex] : null;
        const enabled = option && option.dataset.deviceSpecs === '1';

        if (specs) {
            specs.style.display = enabled ? '' : 'none';
        }

        ['processor', 'ram', 'storage', 'operating_system'].forEach(function (name) {
            const field = document.querySelector('[name="' + name + '"]');
            if (!field) return;

            field.disabled = !enabled;

            if (!enabled) {
                field.value = '';
            }
        });
    }

    if (category) {
        category.addEventListener('change', refreshDeviceSpecifications);
        refreshDeviceSpecifications();
    }
})();
</script>
