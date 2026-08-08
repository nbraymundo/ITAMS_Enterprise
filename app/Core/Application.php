<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\Auth\LoginController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Asset\AssetController;
use App\Controllers\Admin\AssetCategoryController;
use App\Controllers\Admin\ManufacturerController;
use App\Controllers\Admin\BrandController;
use App\Controllers\Admin\ModelController;
use App\Controllers\Admin\CompanyController;
use App\Controllers\Admin\BranchController;
use App\Controllers\Admin\LocationController;
use App\Controllers\Admin\EmployeeController;
use App\Controllers\Admin\AuditLogController;

class Application
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Start Session
        |--------------------------------------------------------------------------
        */

        Session::start();

        /*
        |--------------------------------------------------------------------------
        | Initialize Database Connection
        |--------------------------------------------------------------------------
        */

        Database::connection();

        /*
        |--------------------------------------------------------------------------
        | Create Request & Router
        |--------------------------------------------------------------------------
        */

        $request = new Request();
        $router  = new Router();

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/',
            [DashboardController::class, 'index']
        );

        $router->get(
            '/dashboard',
            [DashboardController::class, 'index']
        );

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/login',
            [LoginController::class, 'index']
        );

        $router->post(
            '/login',
            [LoginController::class, 'store']
        );

        $router->get(
            '/logout',
            [LoginController::class, 'logout']
        );

        /*
        |--------------------------------------------------------------------------
        | Asset Management
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/assets',
            [AssetController::class, 'index']
        );

        $router->get(
            '/assets/create',
            [AssetController::class, 'create']
        );

        $router->post(
            '/assets',
            [AssetController::class, 'store']
        );

        $router->get(
            '/assets/edit',
            [AssetController::class, 'edit']
        );

        $router->post(
            '/assets/update',
            [AssetController::class, 'update']
        );

        $router->post(
            '/assets/delete',
            [AssetController::class, 'delete']
        );

        /*
        |--------------------------------------------------------------------------
        | Asset Categories
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/asset-categories',
            [AssetCategoryController::class, 'index']
        );

        $router->get(
            '/admin/asset-categories/create',
            [AssetCategoryController::class, 'create']
        );

        $router->post(
            '/admin/asset-categories',
            [AssetCategoryController::class, 'store']
        );

        $router->get(
            '/admin/asset-categories/edit',
            [AssetCategoryController::class, 'edit']
        );

        $router->post(
            '/admin/asset-categories/update',
            [AssetCategoryController::class, 'update']
        );

        $router->post(
            '/admin/asset-categories/deactivate',
            [AssetCategoryController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Manufacturers
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/manufacturers',
            [ManufacturerController::class, 'index']
        );

        $router->get(
            '/admin/manufacturers/create',
            [ManufacturerController::class, 'create']
        );

        $router->post(
            '/admin/manufacturers',
            [ManufacturerController::class, 'store']
        );

        $router->get(
            '/admin/manufacturers/edit',
            [ManufacturerController::class, 'edit']
        );

        $router->post(
            '/admin/manufacturers/update',
            [ManufacturerController::class, 'update']
        );

        $router->post(
            '/admin/manufacturers/deactivate',
            [ManufacturerController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Asset Brands
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/brands',
            [BrandController::class, 'index']
        );

        $router->get(
            '/admin/brands/create',
            [BrandController::class, 'create']
        );

        $router->post(
            '/admin/brands',
            [BrandController::class, 'store']
        );

        $router->get(
            '/admin/brands/edit',
            [BrandController::class, 'edit']
        );

        $router->post(
            '/admin/brands/update',
            [BrandController::class, 'update']
        );

        $router->post(
            '/admin/brands/deactivate',
            [BrandController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Asset Models
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/models',
            [ModelController::class, 'index']
        );

        $router->get(
            '/admin/models/create',
            [ModelController::class, 'create']
        );

        $router->post(
            '/admin/models',
            [ModelController::class, 'store']
        );

        $router->get(
            '/admin/models/edit',
            [ModelController::class, 'edit']
        );

        $router->post(
            '/admin/models/update',
            [ModelController::class, 'update']
        );

        $router->post(
            '/admin/models/deactivate',
            [ModelController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Companies
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/companies',
            [CompanyController::class, 'index']
        );

        $router->get(
            '/admin/companies/create',
            [CompanyController::class, 'create']
        );

        $router->post(
            '/admin/companies',
            [CompanyController::class, 'store']
        );

        $router->get(
            '/admin/companies/edit',
            [CompanyController::class, 'edit']
        );

        $router->post(
            '/admin/companies/update',
            [CompanyController::class, 'update']
        );

        $router->post(
            '/admin/companies/deactivate',
            [CompanyController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/branches',
            [BranchController::class, 'index']
        );

        $router->get(
            '/admin/branches/create',
            [BranchController::class, 'create']
        );

        $router->post(
            '/admin/branches',
            [BranchController::class, 'store']
        );

        $router->get(
            '/admin/branches/edit',
            [BranchController::class, 'edit']
        );

        $router->post(
            '/admin/branches/update',
            [BranchController::class, 'update']
        );

        $router->post(
            '/admin/branches/deactivate',
            [BranchController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Locations
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/locations',
            [LocationController::class, 'index']
        );

        $router->get(
            '/admin/locations/create',
            [LocationController::class, 'create']
        );

        $router->post(
            '/admin/locations',
            [LocationController::class, 'store']
        );

        $router->get(
            '/admin/locations/edit',
            [LocationController::class, 'edit']
        );

        $router->post(
            '/admin/locations/update',
            [LocationController::class, 'update']
        );

        $router->post(
            '/admin/locations/deactivate',
            [LocationController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/employees',
            [EmployeeController::class, 'index']
        );

        $router->get(
            '/admin/employees/create',
            [EmployeeController::class, 'create']
        );

        $router->post(
            '/admin/employees',
            [EmployeeController::class, 'store']
        );

        $router->get(
            '/admin/employees/edit',
            [EmployeeController::class, 'edit']
        );

        $router->post(
            '/admin/employees/update',
            [EmployeeController::class, 'update']
        );

        $router->post(
            '/admin/employees/deactivate',
            [EmployeeController::class, 'deactivate']
        );

        /*
        |--------------------------------------------------------------------------
        | Audit Logs
        |--------------------------------------------------------------------------
        */

        $router->get(
            '/admin/audit-logs',
            [AuditLogController::class, 'index']
        );

        /*
        |--------------------------------------------------------------------------
        | Dispatch Request
        |--------------------------------------------------------------------------
        */

        $router->dispatch($request);
    }
}