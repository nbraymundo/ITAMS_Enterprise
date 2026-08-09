<!-- Job Title Code -->

<div class="col-md-6">

    <label
        for="job_title_code"
        class="form-label">

        Job Title Code

    </label>

    <input
        type="text"
        id="job_title_code"
        name="job_title_code"
        class="form-control"
        maxlength="20"
        value="<?= htmlspecialchars(
            $jobTitle['job_title_code'] ?? ''
        ) ?>"
        required>

</div>


<!-- Job Title -->

<div class="col-md-6">

    <label
        for="job_title"
        class="form-label">

        Job Title

    </label>

    <input
        type="text"
        id="job_title"
        name="job_title"
        class="form-control"
        maxlength="150"
        value="<?= htmlspecialchars(
            $jobTitle['job_title'] ?? ''
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
        rows="3"
        maxlength="255"><?= htmlspecialchars(
            $jobTitle['description'] ?? ''
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
    $jobTitleStatus =
        $jobTitle['status']
        ?? 'Active';
    ?>

    <select
        id="status"
        name="status"
        class="form-select">

        <option
            value="Active"
            <?= $jobTitleStatus === 'Active'
                ? 'selected'
                : '' ?>>

            Active

        </option>

        <option
            value="Inactive"
            <?= $jobTitleStatus === 'Inactive'
                ? 'selected'
                : '' ?>>

            Inactive

        </option>

    </select>

</div>