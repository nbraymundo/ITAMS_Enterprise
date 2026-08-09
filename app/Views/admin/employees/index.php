<?php

declare(strict_types=1);

?>

<div class="itams-page">


    <!-- =====================================================
         PAGE HEADER
         ====================================================== -->

    <div class="itams-page-header">

        <div class="itams-page-header-content">

            <h1 class="itams-page-title">
                Employees
            </h1>

            <p class="itams-page-description">
                Manage employees and their organizational assignments.
            </p>

        </div>


        <div class="itams-page-actions">

            <a
                href="/admin/employees/create"
                class="btn btn-primary">

                <i class="bi bi-person-plus me-1"></i>

                Add Employee

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
                action="/admin/employees">

                <div class="row g-2 align-items-center">


                    <!-- Search Input -->

                    <div class="col-md-8">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search employee no., name, email, department, location..."
                            value="<?= htmlspecialchars(
                                $search ?? ''
                            ) ?>">

                    </div>


                    <!-- Search Button -->

                    <div class="col-auto">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>

                    </div>


                    <!-- Reset Button -->

                    <div class="col-auto">

                        <a
                            href="/admin/employees"
                            class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        <!-- =================================================
             EMPLOYEE TABLE
             ================================================== -->

        <div class="itams-table-container">

            <table class="table table-hover align-middle">


                <!-- =================================================
                     TABLE HEADER
                     ================================================== -->

                <thead>

                    <tr>

                        <th>
                            Employee No.
                        </th>

                        <th>
                            Employee
                        </th>

                        <th>
                            Job Title
                        </th>

                        <th>
                            Department
                        </th>

                        <th>
                            Location
                        </th>

                        <th>
                            Branch
                        </th>

                        <th>
                            Company
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <!-- =================================================
                     TABLE BODY
                     ================================================== -->

                <tbody>

                    <?php if (empty($employees)): ?>

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i
                                        class="bi bi-people"
                                        style="font-size: 2rem;">
                                    </i>

                                    <div class="mt-2">

                                        No Employees Found

                                    </div>

                                    <small>

                                        Create an employee to get started.

                                    </small>

                                </div>

                            </td>

                        </tr>

                    <?php else: ?>


                        <?php foreach (
                            $employees as $employee
                        ): ?>

                            <tr>


                                <!-- =================================================
                                     EMPLOYEE NUMBER
                                     ================================================== -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $employee[
                                                'employee_no'
                                            ] ?? ''
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- =================================================
                                     EMPLOYEE
                                     ================================================== -->

                                <td>

                                    <div class="employee-table-name">

                                        <strong>

                                            <?= htmlspecialchars(
                                                trim(
                                                    (
                                                        $employee[
                                                            'first_name'
                                                        ] ?? ''
                                                    )
                                                    . ' '
                                                    .
                                                    (
                                                        $employee[
                                                            'last_name'
                                                        ] ?? ''
                                                    )
                                                )
                                            ) ?>

                                        </strong>


                                        <?php if (
                                            !empty(
                                                $employee['email']
                                            )
                                        ): ?>

                                            <small>

                                                <?= htmlspecialchars(
                                                    $employee['email']
                                                ) ?>

                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </td>


                                <!-- =================================================
                                     JOB TITLE
                                     ================================================== -->

                                <td>

                                    <?= htmlspecialchars(
                                        $employee[
                                            'job_title'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- =================================================
                                     DEPARTMENT
                                     ================================================== -->

                                <td>

                                    <?= htmlspecialchars(
                                        $employee[
                                            'department_name'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- =================================================
                                     LOCATION
                                     ================================================== -->

                                <td>

                                    <div>

                                        <?= htmlspecialchars(
                                            $employee[
                                                'location_name'
                                            ] ?? '-'
                                        ) ?>

                                    </div>


                                    <?php if (
                                        !empty(
                                            $employee[
                                                'location_code'
                                            ]
                                        )
                                    ): ?>

                                        <small class="text-muted">

                                            <?= htmlspecialchars(
                                                $employee[
                                                    'location_code'
                                                ]
                                            ) ?>

                                        </small>

                                    <?php endif; ?>

                                </td>


                                <!-- =================================================
                                     BRANCH
                                     ================================================== -->

                                <td>

                                    <?= htmlspecialchars(
                                        $employee[
                                            'branch_name'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- =================================================
                                     COMPANY
                                     ================================================== -->

                                <td>

                                    <?= htmlspecialchars(
                                        $employee[
                                            'company_name'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- =================================================
                                     STATUS
                                     ================================================== -->

                                <td>

                                    <?php

                                    /*
                                     * IMPORTANT:
                                     *
                                     * The employees table does NOT
                                     * contain a "status" column.
                                     *
                                     * Employee status is stored in:
                                     *
                                     * employment_status
                                     *
                                     * Valid values:
                                     * Active
                                     * Inactive
                                     * Resigned
                                     * Terminated
                                     */

                                    $employmentStatus =
                                        $employee[
                                            'employment_status'
                                        ]
                                        ?? 'Active';

                                    ?>


                                    <?php if (
                                        $employmentStatus === 'Active'
                                    ): ?>

                                        <span
                                            class="badge bg-success">

                                            Active

                                        </span>


                                    <?php elseif (
                                        $employmentStatus === 'Inactive'
                                    ): ?>

                                        <span
                                            class="badge bg-secondary">

                                            Inactive

                                        </span>


                                    <?php elseif (
                                        $employmentStatus === 'Resigned'
                                    ): ?>

                                        <span
                                            class="badge bg-warning text-dark">

                                            Resigned

                                        </span>


                                    <?php elseif (
                                        $employmentStatus === 'Terminated'
                                    ): ?>

                                        <span
                                            class="badge bg-danger">

                                            Terminated

                                        </span>


                                    <?php else: ?>

                                        <span
                                            class="badge bg-secondary">

                                            <?= htmlspecialchars(
                                                $employmentStatus
                                            ) ?>

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- =================================================
                                     ACTIONS
                                     ================================================== -->

                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1">


                                        <!-- =================================================
                                             EDIT
                                             ================================================== -->

                                        <a
                                            href="/admin/employees/edit?id=<?= (int) $employee['id'] ?>"
                                            class="btn btn-warning"
                                            title="Edit Employee">

                                            <i
                                                class="bi bi-pencil">
                                            </i>

                                        </a>


                                        <!-- =================================================
                                             DEACTIVATE
                                             ================================================== -->

                                        <?php if (
                                            (
                                                $employee[
                                                    'employment_status'
                                                ] ?? ''
                                            ) === 'Active'
                                        ): ?>

                                            <form
                                                method="POST"
                                                action="/admin/employees/deactivate"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to deactivate this Employee?');">


                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $employee['id'] ?>">


                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Deactivate Employee">

                                                    <i
                                                        class="bi bi-slash-circle">
                                                    </i>

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