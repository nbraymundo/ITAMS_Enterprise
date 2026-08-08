<?php

$branch = $branch ?? [];
$companies = $companies ?? [];

?>

<!-- Branch Code -->

<div class="col-md-6">

    <label
        for="branch_code"
        class="form-label">

        Branch Code
        <span class="text-danger">*</span>

    </label>

    <input
        type="text"
        id="branch_code"
        name="branch_code"
        class="form-control"
        maxlength="20"
        value="<?= htmlspecialchars(
            (string) ($branch['branch_code'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
        required>

</div>


<!-- Branch Name -->

<div class="col-md-6">

    <label
        for="branch_name"
        class="form-label">

        Branch Name
        <span class="text-danger">*</span>

    </label>

    <input
        type="text"
        id="branch_name"
        name="branch_name"
        class="form-control"
        maxlength="150"
        value="<?= htmlspecialchars(
            (string) ($branch['branch_name'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
        required>

</div>


<!-- Company -->

<div class="col-md-6">

    <label
        for="company_id"
        class="form-label">

        Company
        <span class="text-danger">*</span>

    </label>

    <select
        id="company_id"
        name="company_id"
        class="form-select"
        required>

        <option value="">
            -- Select Company --
        </option>

        <?php foreach ($companies as $company): ?>

            <option
                value="<?= (int) ($company['id'] ?? 0) ?>"
                <?= (
                    (int) ($branch['company_id'] ?? 0)
                    === (int) ($company['id'] ?? 0)
                ) ? 'selected' : '' ?>>

                <?= htmlspecialchars(
                    (string) ($company['company_name'] ?? ''),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

                <?php if (!empty($company['company_code'])): ?>

                    (<?= htmlspecialchars(
                        (string) $company['company_code'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>)

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

    <?php if (empty($companies)): ?>

        <div class="form-text text-danger">
            No active companies are available.
        </div>

    <?php endif; ?>

</div>


<!-- Address -->

<div class="col-md-6">

    <label
        for="address"
        class="form-label">

        Address

    </label>

    <input
        type="text"
        id="address"
        name="address"
        class="form-control"
        maxlength="255"
        value="<?= htmlspecialchars(
            (string) ($branch['address'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        ) ?>">

</div>


<!-- Status -->

<div class="col-md-6">

    <label
        for="status"
        class="form-label">

        Status

    </label>

    <select
        id="status"
        name="status"
        class="form-select">

        <option
            value="Active"
            <?= (
                ($branch['status'] ?? 'Active') === 'Active'
            ) ? 'selected' : '' ?>>

            Active

        </option>

        <option
            value="Inactive"
            <?= (
                ($branch['status'] ?? '') === 'Inactive'
            ) ? 'selected' : '' ?>>

            Inactive

        </option>

    </select>

</div>