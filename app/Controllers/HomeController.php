<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        echo "<h1>ITAMS Enterprise</h1>";
        echo "<p>Router Working Successfully</p>";
    }
}