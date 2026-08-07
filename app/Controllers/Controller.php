<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }
}