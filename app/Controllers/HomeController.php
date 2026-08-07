<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;

class HomeController extends Controller
{
    public function index(): void
{
    $config = Config::get('app');

    \App\Core\View::render('home', [
        'title' => $config['name']
    ]);
}
}