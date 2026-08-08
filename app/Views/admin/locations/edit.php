<?php

declare(strict_types=1);

$location = $location ?? [];
$branches = $branches ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Edit Location</h2>

        <p class="text-muted mb-0">
            Update asset location information.
        </p>

    </div>

    <a
        href="/admin/locations"
        class="btn btn-secondary">

        <i class="bi bi-arrow-left"></i>
        Back

    </a>

</div>


<div class="card">

    <div class="card-body">

        <form
            method="POST"
            action="/admin/locations/update">

            <input
                type="hidden"
                name="id"
                value="<?= (int) ($location['id'] ?? 0) ?>">


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
                                value="<?= (int) $branch['id'] ?>"
                                <?= (
                                    (int) ($location['branch_id'] ?? 0)
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


                <div class="col-md-6">

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
                        maxlength="100"
                        value="<?= htmlspecialchars(
                            $location['floor'] ?? ''
                        ) ?>">

                </div>


                <div class="col-md-6">

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
                        maxlength="100"
                        value="<?= htmlspecialchars(
                            $location['room'] ?? ''
                        ) ?>">

                </div>


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
                                ($location['status'] ?? 'Active')
                                === 'Active'
                            )
                                ? 'selected'
                                : ''
                            ?>>

                            Active

                        </option>

                        <option
                            value="Inactive"
                            <?= (
                                ($location['status'] ?? '')
                                === 'Inactive'
                            )
                                ? 'selected'
                                : ''
                            ?>>

                            Inactive

                        </option>

                    </select>

                </div>

            </div>


            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Save

                </button>


                <a
                    href="/admin/locations"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>