<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\Auth\LoginController;
use App\Controllers\Dashboard\DashboardController;
use App\Controllers\Asset\AssetController;
use App\Controllers\Admin\AssetCategoryController;
use App\Controllers\Admin\ManufacturerController;
use App\Controllers\Admin\BrandController;
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