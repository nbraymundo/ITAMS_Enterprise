<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\View;
use App\Middleware\AuthMiddleware;
use App\Services\AuditLogService;
use App\Core\Paginator;

class AuditLogController
{
    private AuditLogService $service;

    public function __construct()
    {
        $this->service = new AuditLogService();
    }

    public function index(): void
    {
        AuthMiddleware::handle();

        $request = new Request();

        $page = max(
            1,
            (int)$request->get('page', 1)
        );

        $perPage = max(
            10,
            (int)$request->get('per_page', 20)
        );

        $totalRecords = $this->service->count();

        $paginator = new Paginator(
            $totalRecords,
            $page,
            $perPage
        );

        View::render(
            'admin/audit-logs/index',
            [
                'title'      => 'Audit Logs',
                'logs'       => $this->service->all(
                    $page,
                    $perPage
                ),
                'perPage'    => $perPage,
                'paginator'  => $paginator
            ]
        );
    }
}