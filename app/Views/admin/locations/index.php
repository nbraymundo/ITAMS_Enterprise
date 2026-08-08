<?php

$locations = $locations ?? [];
$search = $search ?? '';
$success = $success ?? '';
$error = $error ?? '';

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Locations</h2>

        <p class="text-muted mb-0">
            Manage asset locations.
        </p>

    </div>

    <a
        href="/admin/locations/create"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Add Location

    </a>

</div>


<?php if (!empty($success)): ?>

    <div class="alert alert-success">

        <?= htmlspecialchars(
            (string) $success,
            ENT_QUOTES,
            'UTF-8'
        ) ?>

    </div>

<?php endif; ?>


<?php if (!empty($error)): ?>

    <div class="alert alert-danger">

        <?= htmlspecialchars(
            (string) $error,
            ENT_QUOTES,
            'UTF-8'
        ) ?>

    </div>

<?php endif; ?>


<div class="card shadow-sm">

    <div class="card-body">

        <form
            method="GET"
            action="/admin/locations"
            class="row g-2 mb-4">

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search location, branch, or company..."
                    value="<?= htmlspecialchars(
                        (string) $search,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>">

            </div>


            <div class="col-auto">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-search"></i>

                    Search

                </button>

            </div>


            <div class="col-auto">

                <a
                    href="/admin/locations"
                    class="btn btn-secondary">

                    Reset

                </a>

            </div>

        </form>


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Code</th>

                        <th>Location</th>

                        <th>Company</th>

                        <th>Branch</th>

                        <th>Floor</th>

                        <th>Room</th>

                        <th>Status</th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (empty($locations)): ?>

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-5">

                            <div class="text-muted">

                                <i
                                    class="bi bi-geo-alt"
                                    style="font-size: 40px;">
                                </i>

                                <div class="mt-2">

                                    No Locations Found

                                </div>

                            </div>

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($locations as $location): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars(
                                    (string) (
                                        $location['location_code']
                                        ?? ''
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        (string) (
                                            $location['location_name']
                                            ?? ''
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </strong>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    (string) (
                                        $location['company_name']
                                        ?? ''
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                <?php if (
                                    !empty(
                                        $location['company_code']
                                    )
                                ): ?>

                                    <small class="text-muted">

                                        (
                                        <?= htmlspecialchars(
                                            (string) (
                                                $location[
                                                    'company_code'
                                                ]
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                        )

                                    </small>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    (string) (
                                        $location['branch_name']
                                        ?? ''
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                <?php if (
                                    !empty(
                                        $location['branch_code']
                                    )
                                ): ?>

                                    <small class="text-muted">

                                        (
                                        <?= htmlspecialchars(
                                            (string) (
                                                $location[
                                                    'branch_code'
                                                ]
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                        )

                                    </small>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    (string) (
                                        $location['floor']
                                        ?? ''
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    (string) (
                                        $location['room']
                                        ?? ''
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </td>


                            <td>

                                <?php if (
                                    ($location['status']
                                        ?? 'Active')
                                    === 'Active'
                                ): ?>

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td class="text-center">

                                <a
                                    href="/admin/locations/edit?id=<?= (int) $location['id'] ?>"
                                    class="btn btn-warning btn-sm"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <?php if (
                                    ($location['status']
                                        ?? 'Active')
                                    === 'Active'
                                ): ?>

                                    <form
                                        method="POST"
                                        action="/admin/locations/deactivate"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to deactivate this location?');">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $location['id'] ?>">

                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger btn-sm"
                                            title="Deactivate">

                                            <i class="bi bi-slash-circle"></i>

                                        </button>

                                    </form>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>