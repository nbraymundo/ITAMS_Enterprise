<?php

declare(strict_types=1);

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Core\View;

class DashboardController extends Controller
{
    public function index(): void
    {
        View::render('dashboard/index', [
            'title' => 'Dashboard'
        ]);
    }
}