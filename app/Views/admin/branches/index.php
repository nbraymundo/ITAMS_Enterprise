<?php

declare(strict_types=1);

$branches = $branches ?? [];
$search = $search ?? '';

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>Branches</h2>

        <p class="text-muted mb-0">
            Manage Company Branches
        </p>
    </div>

    <a
        href="/admin/branches/create"
        class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Add Branch

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

        <form
            method="GET"
            action="/admin/branches"
            class="row g-2 mb-4">

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search branch or company..."
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
                    href="/admin/branches"
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

                        <th>Branch</th>

                        <th>Company</th>

                        <th>Address</th>

                        <th>Status</th>

                        <th class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (empty($branches)): ?>

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5">

                            <div class="text-muted">

                                <i
                                    class="bi bi-diagram-3"
                                    style="font-size: 40px;">
                                </i>

                                <div class="mt-2">

                                    No Branches Found

                                </div>

                            </div>

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($branches as $branch): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars(
                                    $branch['branch_code']
                                ) ?>
                            </td>


                            <td>
                                <strong>
                                    <?= htmlspecialchars(
                                        $branch['branch_name']
                                    ) ?>
                                </strong>
                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $branch['company_name'] ?? ''
                                ) ?>

                                <?php if (
                                    !empty($branch['company_code'])
                                ): ?>

                                    <small class="text-muted">

                                        (
                                        <?= htmlspecialchars(
                                            $branch['company_code']
                                        ) ?>
                                        )

                                    </small>

                                <?php endif; ?>

                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $branch['address'] ?? ''
                                ) ?>
                            </td>


                            <td>

                                <?php if (
                                    ($branch['status'] ?? 'Active')
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
                                    href="/admin/branches/edit?id=<?= (int) $branch['id'] ?>"
                                    class="btn btn-warning btn-sm"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <?php if (
                                    ($branch['status'] ?? 'Active')
                                    === 'Active'
                                ): ?>

                                    <form
                                        method="POST"
                                        action="/admin/branches/deactivate"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to deactivate this branch?');">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int) $branch['id'] ?>">

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