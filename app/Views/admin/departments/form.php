<!-- Department Code -->

<div class="col-md-6">

    <label
        for="department_code"
        class="form-label">

        Department Code

    </label>

    <input
        type="text"
        id="department_code"
        name="department_code"
        class="form-control"
        maxlength="20"
        value="<?= htmlspecialchars(
            $department['department_code'] ?? ''
        ) ?>"
        required>

</div>


<!-- Department Name -->

<div class="col-md-6">

    <label
        for="department_name"
        class="form-label">

        Department Name

    </label>

    <input
        type="text"
        id="department_name"
        name="department_name"
        class="form-control"
        maxlength="150"
        value="<?= htmlspecialchars(
            $department['department_name'] ?? ''
        ) ?>"
        required>

</div>


<!-- Description -->

<div class="col-md-12">

    <label
        for="description"
        class="form-label">

        Description

    </label>

    <textarea
        id="description"
        name="description"
        class="form-control"
        rows="4"
        maxlength="255"><?= htmlspecialchars(
            $department['description'] ?? ''
        ) ?></textarea>

</div>


<!-- Status -->

<div class="col-md-6">

    <label
        for="status"
        class="form-label">

        Status

    </label>

    <?php
    $departmentStatus =
        $department['status']
        ?? 'Active';
    ?>

    <select
        id="status"
        name="status"
        class="form-select">

        <option
            value="Active"
            <?= $departmentStatus === 'Active'
                ? 'selected'
                : '' ?>>

            Active

        </option>

        <option
            value="Inactive"
            <?= $departmentStatus === 'Inactive'
                ? 'selected'
                : '' ?>>

            Inactive

        </option>

    </select>

</div>