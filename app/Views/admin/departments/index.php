<div class="itams-page">

    <!-- =====================================================
         PAGE HEADER
         ====================================================== -->

    <div class="itams-page-header">

        <div class="itams-page-header-content">

            <h1 class="itams-page-title">
                Departments
            </h1>

            <p class="itams-page-description">
                Manage company departments.
            </p>

        </div>


        <div class="itams-page-actions">

            <a
                href="/admin/departments/create"
                class="btn btn-primary">

                <i class="bi bi-plus-circle me-1"></i>

                Add Department

            </a>

        </div>

    </div>


    <!-- =====================================================
         SUCCESS MESSAGE
         ====================================================== -->

    <?php if (!empty($success)): ?>

        <div class="alert alert-success">

            <?= htmlspecialchars($success) ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         ERROR MESSAGE
         ====================================================== -->

    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         CONTENT CARD
         ====================================================== -->

    <div class="itams-content-card">


        <!-- =================================================
             SEARCH
             ================================================== -->

        <div class="itams-search-panel">

            <form
                method="GET"
                action="/admin/departments">

                <div class="row g-2 align-items-center">


                    <!-- Search -->

                    <div class="col-md-8">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search department code or department name..."
                            value="<?= htmlspecialchars(
                                $search ?? ''
                            ) ?>">

                    </div>


                    <!-- Search button -->

                    <div class="col-auto">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>

                    </div>


                    <!-- Reset -->

                    <div class="col-auto">

                        <a
                            href="/admin/departments"
                            class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        <!-- =================================================
             TABLE
             ================================================== -->

        <div class="itams-table-container">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>
                            Code
                        </th>

                        <th>
                            Department
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (empty($departments)): ?>

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i
                                        class="bi bi-diagram-2"
                                        style="font-size: 2rem;">
                                    </i>

                                    <div class="mt-2">

                                        No Departments Found

                                    </div>

                                    <small>
                                        Create a department to get started.
                                    </small>

                                </div>

                            </td>

                        </tr>

                    <?php else: ?>


                        <?php foreach (
                            $departments
                            as $department
                        ): ?>

                            <tr>


                                <!-- Code -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $department[
                                                'department_code'
                                            ] ?? ''
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- Department -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $department[
                                                'department_name'
                                            ] ?? ''
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- Description -->

                                <td>

                                    <?= htmlspecialchars(
                                        $department[
                                            'description'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- Status -->

                                <td>

                                    <?php if (
                                        (
                                            $department['status']
                                            ?? ''
                                        ) === 'Active'
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


                                <!-- Actions -->

                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1">


                                        <!-- Edit -->

                                        <a
                                            href="/admin/departments/edit?id=<?= (int) $department['id'] ?>"
                                            class="btn btn-warning"
                                            title="Edit Department">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        <!-- Deactivate -->

                                        <?php if (
                                            (
                                                $department[
                                                    'status'
                                                ] ?? ''
                                            ) === 'Active'
                                        ): ?>

                                            <form
                                                method="POST"
                                                action="/admin/departments/deactivate"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to deactivate this Department?');">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $department['id'] ?>">

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Deactivate Department">

                                                    <i class="bi bi-slash-circle"></i>

                                                </button>

                                            </form>

                                        <?php endif; ?>


                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>