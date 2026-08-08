<?php

declare(strict_types=1);

$branches = $branches ?? [];
$location = $location ?? [];

?>

<div class="row g-3">

    <div class="col-md-6">

        <label
            for="location_code"
            class="form-label">

            Location Code

        </label>

        <input
            type="text"
            id="location_code"
            name="location_code"
            class="form-control"
            maxlength="20"
            value="<?= htmlspecialchars(
                $location['location_code'] ?? ''
            ) ?>"
            required>

    </div>


    <div class="col-md-6">

        <label
            for="location_name"
            class="form-label">

            Location Name

        </label>

        <input
            type="text"
            id="location_name"
            name="location_name"
            class="form-control"
            maxlength="150"
            value="<?= htmlspecialchars(
                $location['location_name'] ?? ''
            ) ?>"
            required>

    </div>


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
                    value="<?= (int) $branch['id'] ?>">

                    <?= htmlspecialchars(
                        $branch['branch_name']
                    ) ?>

                    <?php if (
                        !empty($branch['branch_code'])
                    ): ?>

                        (<?= htmlspecialchars(
                            $branch['branch_code']
                        ) ?>)

                    <?php endif; ?>

                </option>

            <?php endforeach; ?>

        </select>

    </div>


    <div class="col-md-3">

        <label
            for="floor"
            class="form-label">

            Floor

        </label>

        <input
            type="text"
            id="floor"
            name="floor"
            class="form-control"
            maxlength="50"
            value="<?= htmlspecialchars(
                $location['floor'] ?? ''
            ) ?>">

    </div>


    <div class="col-md-3">

        <label
            for="room"
            class="form-label">

            Room

        </label>

        <input
            type="text"
            id="room"
            name="room"
            class="form-control"
            maxlength="50"
            value="<?= htmlspecialchars(
                $location['room'] ?? ''
            ) ?>">

    </div>


    <div class="col-md-8">

        <label
            for="description"
            class="form-label">

            Description

        </label>

        <textarea
            id="description"
            name="description"
            class="form-control"
            maxlength="255"
            rows="3"><?= htmlspecialchars(
                $location['description'] ?? ''
            ) ?></textarea>

    </div>


    <div class="col-md-4">

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
                selected>

                Active

            </option>

            <option
                value="Inactive">

                Inactive

            </option>

        </select>

    </div>

</div>