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
                Job Titles
            </h1>

            <p class="itams-page-description">
                Manage employee job titles.
            </p>

        </div>


        <div class="itams-page-actions">

            <a
                href="/admin/job-titles/create"
                class="btn btn-primary">

                <i class="bi bi-plus-circle me-1"></i>

                Add Job Title

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
                action="/admin/job-titles">

                <div class="row g-2 align-items-center">


                    <div class="col-md-8">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search job title code or job title..."
                            value="<?= htmlspecialchars(
                                $search ?? ''
                            ) ?>">

                    </div>


                    <div class="col-auto">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>

                    </div>


                    <div class="col-auto">

                        <a
                            href="/admin/job-titles"
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
                            Job Title
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

                    <?php if (empty($jobTitles)): ?>

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i
                                        class="bi bi-person-badge"
                                        style="font-size: 2rem;">
                                    </i>

                                    <div class="mt-2">

                                        No Job Titles Found

                                    </div>

                                    <small>
                                        Create a job title to get started.
                                    </small>

                                </div>

                            </td>

                        </tr>

                    <?php else: ?>


                        <?php foreach (
                            $jobTitles
                            as $jobTitle
                        ): ?>

                            <tr>


                                <!-- Code -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $jobTitle[
                                                'job_title_code'
                                            ] ?? ''
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- Job Title -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $jobTitle[
                                                'job_title'
                                            ] ?? ''
                                        ) ?>

                                    </strong>

                                </td>


                                <!-- Description -->

                                <td>

                                    <?= htmlspecialchars(
                                        $jobTitle[
                                            'description'
                                        ] ?? '-'
                                    ) ?>

                                </td>


                                <!-- Status -->

                                <td>

                                    <?php if (
                                        (
                                            $jobTitle[
                                                'status'
                                            ] ?? ''
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
                                            href="/admin/job-titles/edit?id=<?= (int) $jobTitle['id'] ?>"
                                            class="btn btn-warning"
                                            title="Edit Job Title">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        <!-- Deactivate -->

                                        <?php if (
                                            (
                                                $jobTitle[
                                                    'status'
                                                ] ?? ''
                                            ) === 'Active'
                                        ): ?>

                                            <form
                                                method="POST"
                                                action="/admin/job-titles/deactivate"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to deactivate this Job Title?');">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $jobTitle['id'] ?>">

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger"
                                                    title="Deactivate Job Title">

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