<?php

declare(strict_types=1);

namespace App\Controllers\Asset;

use App\Core\View;
use App\Core\Session;
use App\Middleware\AuthMiddleware;
use App\Models\Asset;

class AssetController
{
    public function index(): void
{
    AuthMiddleware::handle();

    $assetModel = new Asset();

    View::render(
        'asset/index',
        [
            'title'      => 'Asset Management',
            'user'       => Session::get('auth'),
            'assets'     => $assetModel->all(),
            'assetCount' => $assetModel->count()
        ]
    );
}

    public function create(): void
    {
        AuthMiddleware::handle();

        View::render(
            'asset/create',
            [
                'title' => 'Add Asset'
            ]
        );
    }

    public function store(): void
    {
        AuthMiddleware::handle();

        // To be implemented in ASSET-02
    }

    public function edit(): void
    {
        AuthMiddleware::handle();

        View::render(
            'asset/edit',
            [
                'title' => 'Edit Asset'
            ]
        );
    }

    public function update(): void
    {
        AuthMiddleware::handle();

        // To be implemented in ASSET-02
    }

    public function delete(): void
    {
        AuthMiddleware::handle();

        // To be implemented in ASSET-02
    }
}