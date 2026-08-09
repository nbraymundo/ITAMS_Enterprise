<?php

declare(strict_types=1);

$employee = $employee ?? [];

?>

<div class="itams-page">


    <!-- =====================================================
         PAGE HEADER
         ====================================================== -->

    <div class="itams-page-header">

        <div class="itams-page-header-content">

            <h1 class="itams-page-title">
                Edit Employee
            </h1>

            <p class="itams-page-description">
                Update employee information and organizational assignment.
            </p>

        </div>


        <div class="itams-page-actions">

            <a
                href="/admin/employees"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back to Employees

            </a>

        </div>

    </div>


    <!-- =====================================================
         CONTENT CARD
         ====================================================== -->

    <div class="itams-content-card">

        <div class="itams-form-card-body">

            <form
                method="POST"
                action="/admin/employees/update">


                <!-- Employee ID -->

                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) ($employee['id'] ?? 0) ?>">


                <!-- =================================================
                     EMPLOYEE INFORMATION
                     ================================================== -->

                <div class="itams-form-section">

                    <div class="itams-form-section-title">

                        <i class="bi bi-person"></i>

                        Employee Information

                    </div>

                    <div class="itams-form-section-description">

                        Update the employee's identification and contact information.

                    </div>


                    <div class="row g-3 mt-1">


                        <!-- Employee No. -->

                        <div class="col-md-4">

                            <label
                                for="employee_no"
                                class="form-label">

                                Employee No.
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="employee_no"
                                name="employee_no"
                                class="form-control"
                                maxlength="30"
                                required
                                value="<?= htmlspecialchars(
                                    $employee['employee_no'] ?? ''
                                ) ?>">

                        </div>


                        <!-- First Name -->

                        <div class="col-md-4">

                            <label
                                for="first_name"
                                class="form-label">

                                First Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                class="form-control"
                                maxlength="100"
                                required
                                value="<?= htmlspecialchars(
                                    $employee['first_name'] ?? ''
                                ) ?>">

                        </div>


                        <!-- Middle Name -->

                        <div class="col-md-4">

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

                        <div class="col-md-4">

                            <label
                                for="last_name"
                                class="form-label">

                                Last Name
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="form-control"
                                maxlength="100"
                                required
                                value="<?= htmlspecialchars(
                                    $employee['last_name'] ?? ''
                                ) ?>">

                        </div>


                        <!-- Email -->

                        <div class="col-md-4">

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


                        <!-- Mobile No. -->

                        <div class="col-md-4">

                            <label
                                for="mobile_no"
                                class="form-label">

                                Mobile No.

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

                    </div>

                </div>


                <!-- =================================================
                     ORGANIZATIONAL ASSIGNMENT
                     ================================================== -->

                <div class="itams-form-section">

                    <div class="itams-form-section-title">

                        <i class="bi bi-diagram-3"></i>

                        Organizational Assignment

                    </div>

                    <div class="itams-form-section-description">

                        Update the employee's company, branch,
                        department, job title, location, and hiring information.

                    </div>


                    <div class="row g-3 mt-1">


                        <!-- Company -->

                        <div class="col-md-4">

                            <label
                                for="company_id"
                                class="form-label">

                                Company
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="company_id"
                                name="company_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Company
                                </option>

                                <?php foreach (
                                    $companies ?? []
                                    as $company
                                ): ?>

                                    <option
                                        value="<?= (int) $company['id'] ?>"
                                        <?= (
                                            (int) (
                                                $employee[
                                                    'company_id'
                                                ] ?? 0
                                            )
                                            ===
                                            (int) $company['id']
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>>

                                        <?= htmlspecialchars(
                                            $company['company_name']
                                            ?? ''
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Branch -->

                        <div class="col-md-4">

                            <label
                                for="branch_id"
                                class="form-label">

                                Branch
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="branch_id"
                                name="branch_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Branch
                                </option>

                                <?php foreach (
                                    $branches ?? []
                                    as $branch
                                ): ?>

                                    <option
                                        value="<?= (int) $branch['id'] ?>"
                                        <?= (
                                            (int) (
                                                $employee[
                                                    'branch_id'
                                                ] ?? 0
                                            )
                                            ===
                                            (int) $branch['id']
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>>

                                        <?= htmlspecialchars(
                                            $branch['branch_name']
                                            ?? ''
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Department -->

                        <div class="col-md-4">

                            <label
                                for="department_id"
                                class="form-label">

                                Department
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="department_id"
                                name="department_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Department
                                </option>

                                <?php foreach (
                                    $departments ?? []
                                    as $department
                                ): ?>

                                    <option
                                        value="<?= (int) $department['id'] ?>"
                                        <?= (
                                            (int) (
                                                $employee[
                                                    'department_id'
                                                ] ?? 0
                                            )
                                            ===
                                            (int) $department['id']
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>>

                                        <?= htmlspecialchars(
                                            $department[
                                                'department_name'
                                            ]
                                            ?? ''
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Job Title -->

                        <div class="col-md-4">

                            <label
                                for="job_title_id"
                                class="form-label">

                                Job Title
                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="job_title_id"
                                name="job_title_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Job Title
                                </option>

                                <?php foreach (
                                    $jobTitles ?? []
                                    as $jobTitle
                                ): ?>

                                    <option
                                        value="<?= (int) $jobTitle['id'] ?>"
                                        <?= (
                                            (int) (
                                                $employee[
                                                    'job_title_id'
                                                ] ?? 0
                                            )
                                            ===
                                            (int) $jobTitle['id']
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>>

                                        <?= htmlspecialchars(
                                            $jobTitle['job_title']
                                            ?? ''
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Location -->

                        <div class="col-md-4">

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
                                    Select Location
                                </option>

                                <?php foreach (
                                    $locations ?? []
                                    as $location
                                ): ?>

                                    <option
                                        value="<?= (int) $location['id'] ?>"
                                        <?= (
                                            (int) (
                                                $employee[
                                                    'location_id'
                                                ] ?? 0
                                            )
                                            ===
                                            (int) $location['id']
                                        )
                                            ? 'selected'
                                            : ''
                                        ?>>

                                        <?= htmlspecialchars(
                                            (
                                                $location[
                                                    'location_code'
                                                ]
                                                ?? ''
                                            )
                                            . ' - '
                                            . (
                                                $location[
                                                    'location_name'
                                                ]
                                                ?? ''
                                            )
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- Hired Date -->

                        <div class="col-md-4">

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

                    </div>

                </div>


                <!-- =================================================
                     EMPLOYMENT STATUS
                     ================================================== -->

                <div class="itams-form-section">

                    <div class="itams-form-section-title">

                        <i class="bi bi-briefcase"></i>

                        Employment Status

                    </div>

                    <div class="itams-form-section-description">

                        Set the current employment status of the employee.

                    </div>


                    <div class="row g-3 mt-1">


                        <div class="col-md-4">

                            <label
                                for="employment_status"
                                class="form-label">

                                Employment Status

                            </label>

                            <select
                                id="employment_status"
                                name="employment_status"
                                class="form-select">

                                <?php

                                $employmentStatus =
                                    $employee[
                                        'employment_status'
                                    ]
                                    ?? 'Active';

                                ?>

                                <option
                                    value="Active"
                                    <?= $employmentStatus === 'Active'
                                        ? 'selected'
                                        : ''
                                    ?>>

                                    Active

                                </option>

                                <option
                                    value="Inactive"
                                    <?= $employmentStatus === 'Inactive'
                                        ? 'selected'
                                        : ''
                                    ?>>

                                    Inactive

                                </option>

                                <option
                                    value="Resigned"
                                    <?= $employmentStatus === 'Resigned'
                                        ? 'selected'
                                        : ''
                                    ?>>

                                    Resigned

                                </option>

                                <option
                                    value="Terminated"
                                    <?= $employmentStatus === 'Terminated'
                                        ? 'selected'
                                        : ''
                                    ?>>

                                    Terminated

                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     FORM ACTIONS
                     ================================================== -->

                <div class="itams-form-actions">

                    <a
                        href="/admin/employees"
                        class="btn btn-secondary">

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle me-1"></i>

                        Update Employee

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>