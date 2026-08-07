<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;

class HomeController extends Controller
{
    public function index(): void
    {
        $config = Config::get('app');

        echo "<h1>{$config['name']}</h1>";

        echo "<hr>";

        echo "Environment : {$config['environment']}<br>";

        echo "Timezone : {$config['timezone']}<br>";

        echo "Debug : ";

        echo $config['debug'] ? "Enabled" : "Disabled";
    }
}