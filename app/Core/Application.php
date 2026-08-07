<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public function run(): void
    {
        Database::connection();

        echo "<h1>ITAMS Enterprise</h1>";
        echo "<p>Application Bootstrap Successful</p>";
        echo "<p style='color:green;'>Database Connected Successfully</p>";
    }
}