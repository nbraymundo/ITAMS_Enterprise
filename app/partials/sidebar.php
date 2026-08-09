<?php

declare(strict_types=1);

$currentPath = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$currentPath = rtrim(
    $currentPath,
    '/'
);

if ($currentPath === '') {
    $currentPath = '/';
}


/**
 * Determine whether a navigation item is active.
 */
function isNavActive(
    string $path,
    string $currentPath
): bool {

    if ($path === '/') {
        return $currentPath === '/';
    }

    return $currentPath === $path
        || str_starts_with(
            $currentPath,
            $path . '/'
        );
}

?>

<aside class="sidebar">

    <!-- =====================================================
         ITAMS BRAND
         ====================================================== -->

    <div class="sidebar-brand">

        <a
            href="/dashboard"
            class="sidebar-brand-link">

            <div class="sidebar-brand-logo">

                <img
                    src="/images/logo.png"
                    alt="Company Logo">

            </div>

            <div class="sidebar-brand-text">

                <div class="sidebar-brand-title">
                    ITAMS
                </div>

                <div class="sidebar-brand-subtitle">
                    Enterprise
                </div>

            </div>

        </a>

    </div>


    <!-- =====================================================
         MAIN NAVIGATION
         ====================================================== -->

    <nav class="sidebar-navigation">

        <ul class="sidebar-menu">

            <!-- Dashboard -->

            <li>

                <a
                    href="/dashboard"
                    class="<?= isNavActive(
                        '/dashboard',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-speedometer2"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>


            <!-- Assets -->

            <li>

                <a
                    href="/assets"
                    class="<?= isNavActive(
                        '/assets',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-pc-display"></i>

                    <span>
                        Assets
                    </span>

                </a>

            </li>


            <!-- Software -->

            <li>

                <a
                    href="/software"
                    class="<?= isNavActive(
                        '/software',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-grid-fill"></i>

                    <span>
                        Software
                    </span>

                </a>

            </li>


            <!-- Procurement -->

            <li>

                <a
                    href="/procurement"
                    class="<?= isNavActive(
                        '/procurement',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-cart3"></i>

                    <span>
                        Procurement
                    </span>

                </a>

            </li>


            <!-- Reports -->

            <li>

                <a
                    href="/reports"
                    class="<?= isNavActive(
                        '/reports',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-bar-chart-line"></i>

                    <span>
                        Reports
                    </span>

                </a>

            </li>

        </ul>


        <!-- =================================================
             ADMINISTRATION
             ================================================== -->

        <div class="sidebar-section-title">

            Administration

        </div>


        <ul class="sidebar-menu">


            <!-- Asset Categories -->

            <li>

                <a
                    href="/admin/asset-categories"
                    class="<?= isNavActive(
                        '/admin/asset-categories',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-folder"></i>

                    <span>
                        Asset Categories
                    </span>

                </a>

            </li>


            <!-- Audit Logs -->

            <li>

                <a
                    href="/admin/audit-logs"
                    class="<?= isNavActive(
                        '/admin/audit-logs',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-clock-history"></i>

                    <span>
                        Audit Logs
                    </span>

                </a>

            </li>


            <!-- Companies -->

            <li>

                <a
                    href="/admin/companies"
                    class="<?= isNavActive(
                        '/admin/companies',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-building"></i>

                    <span>
                        Companies
                    </span>

                </a>

            </li>


            <!-- Branches -->

            <li>

                <a
                    href="/admin/branches"
                    class="<?= isNavActive(
                        '/admin/branches',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-diagram-3"></i>

                    <span>
                        Branches
                    </span>

                </a>

            </li>


            <!-- Locations -->

            <li>

                <a
                    href="/admin/locations"
                    class="<?= isNavActive(
                        '/admin/locations',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-geo-alt"></i>

                    <span>
                        Locations
                    </span>

                </a>

            </li>


            <!-- Departments -->

            <li>

                <a
                    href="/admin/departments"
                    class="<?= isNavActive(
                        '/admin/departments',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-diagram-2"></i>

                    <span>
                        Departments
                    </span>

                </a>

            </li>


            <!-- Job Titles -->

            <li>

                <a
                    href="/admin/job-titles"
                    class="<?= isNavActive(
                        '/admin/job-titles',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-person-badge"></i>

                    <span>
                        Job Titles
                    </span>

                </a>

            </li>


            <!-- Employees -->

            <li>

                <a
                    href="/admin/employees"
                    class="<?= isNavActive(
                        '/admin/employees',
                        $currentPath
                    ) ? 'active' : '' ?>">

                    <i class="bi bi-people"></i>

                    <span>
                        Employees
                    </span>

                </a>

            </li>

        </ul>

    </nav>

</aside>