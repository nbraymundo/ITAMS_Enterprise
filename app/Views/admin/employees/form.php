<!-- Employee Number -->

<div class="col-md-6">

    <label
        for="employee_no"
        class="form-label">

        Employee Number

    </label>

    <input
        type="text"
        id="employee_no"
        name="employee_no"
        class="form-control"
        maxlength="30"
        value="<?= htmlspecialchars(
            $employee['employee_no'] ?? ''
        ) ?>"
        required>

</div>


<!-- First Name -->

<div class="col-md-6">

    <label
        for="first_name"
        class="form-label">

        First Name

    </label>

    <input
        type="text"
        id="first_name"
        name="first_name"
        class="form-control"
        maxlength="100"
        value="<?= htmlspecialchars(
            $employee['first_name'] ?? ''
        ) ?>"
        required>

</div>


<!-- Middle Name -->

<div class="col-md-6">

    <label
        for="middle_name"
        class="form-label">

        Middle Name

    </label>

    <input
        type="text"
        id="middle_name"
        name="middle_name"
        class="form-control"
        maxlength="100"
        value="<?= htmlspecialchars(
            $employee['middle_name'] ?? ''
        ) ?>">

</div>


<!-- Last Name -->

<div class="col-md-6">

    <label
        for="last_name"
        class="form-label">

        Last Name

    </label>

    <input
        type="text"
        id="last_name"
        name="last_name"
        class="form-control"
        maxlength="100"
        value="<?= htmlspecialchars(
            $employee['last_name'] ?? ''
        ) ?>"
        required>

</div>


<!-- Company -->

<div class="col-md-6">

    <label
        for="company_id"
        class="form-label">

        Company

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
                value="<?= (int) $company['id'] ?>"
                <?= (
                    (int) (
                        $employee['company_id'] ?? 0
                    )
                    === (int) $company['id']
                )
                    ? 'selected'
                    : ''
                ?>>

                <?= htmlspecialchars(
                    $company['company_name']
                ) ?>

                <?php if (
                    !empty($company['company_code'])
                ): ?>

                    (
                    <?= htmlspecialchars(
                        $company['company_code']
                    ) ?>
                    )

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>


<!-- Branch -->

<div class="col-md-6">

    <label
        for="branch_id"
        class="form-label">

        Branch

    </label>

    <select
        id="branch_id"
        name="branch_id"
        class="form-select"
        required>

        <option value="">
            -- Select Branch --
        </option>

        <?php foreach ($branches as $branch): ?>

            <option
                value="<?= (int) $branch['id'] ?>"
                <?= (
                    (int) (
                        $employee['branch_id'] ?? 0
                    )
                    === (int) $branch['id']
                )
                    ? 'selected'
                    : ''
                ?>>

                <?= htmlspecialchars(
                    $branch['branch_name']
                ) ?>

                <?php if (
                    !empty($branch['branch_code'])
                ): ?>

                    (
                    <?= htmlspecialchars(
                        $branch['branch_code']
                    ) ?>
                    )

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>


<!-- Department -->

<div class="col-md-6">

    <label
        for="department_id"
        class="form-label">

        Department

    </label>

    <select
        id="department_id"
        name="department_id"
        class="form-select"
        required>

        <option value="">
            -- Select Department --
        </option>

        <?php foreach ($departments as $department): ?>

            <option
                value="<?= (int) $department['id'] ?>"
                <?= (
                    (int) (
                        $employee['department_id'] ?? 0
                    )
                    === (int) $department['id']
                )
                    ? 'selected'
                    : ''
                ?>>

                <?= htmlspecialchars(
                    $department['department_name']
                ) ?>

                <?php if (
                    !empty($department['department_code'])
                ): ?>

                    (
                    <?= htmlspecialchars(
                        $department['department_code']
                    ) ?>
                    )

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>


<!-- Job Title -->

<div class="col-md-6">

    <label
        for="job_title_id"
        class="form-label">

        Job Title

    </label>

    <select
        id="job_title_id"
        name="job_title_id"
        class="form-select"
        required>

        <option value="">
            -- Select Job Title --
        </option>

        <?php foreach ($jobTitles as $jobTitle): ?>

            <option
                value="<?= (int) $jobTitle['id'] ?>"
                <?= (
                    (int) (
                        $employee['job_title_id'] ?? 0
                    )
                    === (int) $jobTitle['id']
                )
                    ? 'selected'
                    : ''
                ?>>

                <?= htmlspecialchars(
                    $jobTitle['job_title']
                ) ?>

                <?php if (
                    !empty($jobTitle['job_title_code'])
                ): ?>

                    (
                    <?= htmlspecialchars(
                        $jobTitle['job_title_code']
                    ) ?>
                    )

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>


<!-- Location -->

<div class="col-md-6">

    <label
        for="location_id"
        class="form-label">

        Location

    </label>

    <select
        id="location_id"
        name="location_id"
        class="form-select">

        <option value="">
            -- Select Location --
        </option>

        <?php foreach ($locations as $location): ?>

            <option
                value="<?= (int) $location['id'] ?>"
                <?= (
                    (int) (
                        $employee['location_id'] ?? 0
                    )
                    === (int) $location['id']
                )
                    ? 'selected'
                    : ''
                ?>>

                <?= htmlspecialchars(
                    $location['location_name']
                ) ?>

                <?php if (
                    !empty($location['location_code'])
                ): ?>

                    (
                    <?= htmlspecialchars(
                        $location['location_code']
                    ) ?>
                    )

                <?php endif; ?>

            </option>

        <?php endforeach; ?>

    </select>

</div>


<!-- Email -->

<div class="col-md-6">

    <label
        for="email"
        class="form-label">

        Email

    </label>

    <input
        type="email"
        id="email"
        name="email"
        class="form-control"
        maxlength="150"
        value="<?= htmlspecialchars(
            $employee['email'] ?? ''
        ) ?>">

</div>


<!-- Mobile Number -->

<div class="col-md-6">

    <label
        for="mobile_no"
        class="form-label">

        Mobile Number

    </label>

    <input
        type="text"
        id="mobile_no"
        name="mobile_no"
        class="form-control"
        maxlength="30"
        value="<?= htmlspecialchars(
            $employee['mobile_no'] ?? ''
        ) ?>">

</div>


<!-- Employment Status -->

<div class="col-md-6">

    <label
        for="employment_status"
        class="form-label">

        Employment Status

    </label>

    <?php
    $employmentStatus =
        $employee['employment_status']
        ?? 'Active';
    ?>

    <select
        id="employment_status"
        name="employment_status"
        class="form-select"
        required>

        <option
            value="Active"
            <?= $employmentStatus === 'Active'
                ? 'selected'
                : '' ?>>

            Active

        </option>

        <option
            value="Inactive"
            <?= $employmentStatus === 'Inactive'
                ? 'selected'
                : '' ?>>

            Inactive

        </option>

        <option
            value="Resigned"
            <?= $employmentStatus === 'Resigned'
                ? 'selected'
                : '' ?>>

            Resigned

        </option>

        <option
            value="Terminated"
            <?= $employmentStatus === 'Terminated'
                ? 'selected'
                : '' ?>>

            Terminated

        </option>

    </select>

</div>


<!-- Hired Date -->

<div class="col-md-6">

    <label
        for="hired_date"
        class="form-label">

        Hired Date

    </label>

    <input
        type="date"
        id="hired_date"
        name="hired_date"
        class="form-control"
        value="<?= htmlspecialchars(
            $employee['hired_date'] ?? ''
        ) ?>">

</div>