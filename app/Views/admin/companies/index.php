<?php

$companies = $companies ?? [];
$search = $search ?? '';

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Companies</h2>

        <p class="text-muted mb-0">
            Manage Companies
        </p>

    </div>

    <a
        href="/admin/companies/create"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Add Company

    </a>

</div>


<?php if (!empty($success)): ?>

    <div class="alert alert-success">

        <?= htmlspecialchars($success) ?>

    </div>

<?php endif; ?>


<?php if (!empty($error)): ?>

    <div class="alert alert-danger">

        <?= htmlspecialchars($error) ?>

    </div>

<?php endif; ?>


<div class="card">

    <div class="card-body">


        <!-- Search -->

        <form
            method="GET"
            action="/admin/companies"
            class="row g-2 mb-4">

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search company..."
                    value="<?= htmlspecialchars($search) ?>">

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
                    href="/admin/companies"
                    class="btn btn-secondary">

                    Reset

                </a>

            </div>

        </form>


        <!-- Companies Table -->

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Code</th>

                        <th>Company</th>

                        <th>Address</th>

                        <th>Telephone</th>

                        <th>Email</th>

                        <th>Status</th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (empty($companies)): ?>

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-5">

                            <div class="text-muted">

                                <i
                                    class="bi bi-building"
                                    style="font-size: 40px;">
                                </i>

                                <div class="mt-2">

                                    No Companies Found

                                </div>

                            </div>

                        </td>

                    </tr>

                <?php else: ?>


                    <?php foreach ($companies as $company): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars(
                                    $company['company_code']
                                ) ?>

                            </td>


                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        $company['company_name']
                                    ) ?>

                                </strong>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $company['address'] ?? ''
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $company['telephone'] ?? ''
                                ) ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $company['email'] ?? ''
                                ) ?>

                            </td>


                            <td>

                                <?php if (
                                    ($company['status'] ?? 'Active')
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
                                    href="/admin/companies/edit?id=<?= (int) $company['id'] ?>"
                                    class="btn btn-warning btn-sm"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <?php if (
                                    ($company['status'] ?? 'Active')
                                    === 'Active'
                                ): ?>

                                    <form
                                        method="POST"
                                        action="/admin/companies/deactivate"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to deactivate this company?');">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $company['id'] ?>">

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