<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Paginator;
use App\Services\ComponentService;

class ComponentController
{
    private ComponentService $service;

    private Request $request;

    public function __construct()
    {
        $this->service = new ComponentService();

        $this->request = new Request();
    }

    /**
     * Component Inventory
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get(
                'search',
                ''
            )
        );

        $page = (int) $this->request->get(
            'page',
            1
        );

        $perPage = (int) $this->request->get(
            'per_page',
            10
        );

        if ($perPage <= 0) {
            $perPage = 10;
        }

        $total = $this->service->count(
            $search
        );

        $paginator = new Paginator(
            $total,
            $perPage,
            $page
        );

        $components = $this->service->all(
            $search,
            $paginator->limit(),
            $paginator->offset()
        );

        View::render(
            'admin/components/index',
            [
                'title' => 'Component Inventory',

                'components' => $components,

                'search' => $search,

                'perPage' => $perPage,

                'pagination' => $paginator,

                'success' =>
                    Session::getFlash(
                        'success'
                    ),

                'error' =>
                    Session::getFlash(
                        'error'
                    )
            ]
        );
    }

    /**
     * Create Component Form
     */
    public function create(): void
    {
        $suppliers =
            $this->service->suppliers();

        View::render(
            'admin/components/create',
            [
                'title' =>
                    'Add Component',

                'suppliers' =>
                    $suppliers
            ]
        );
    }

    /**
     * Store Component
     */
    public function store(): void
    {
        $result =
            $this->service->create(
                $_POST
            );

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect(
                '/admin/components/create'
            );

            return;
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/components'
        );
    }

    /**
     * Edit Component Form
     */
    public function edit(): void
    {
        $id = (int) $this->request->get(
            'id',
            0
        );

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid component ID.'
            );

            Response::redirect(
                '/admin/components'
            );

            return;
        }

        $component =
            $this->service->find($id);

        if (!$component) {

            Session::flash(
                'error',
                'Component not found.'
            );

            Response::redirect(
                '/admin/components'
            );

            return;
        }

        $suppliers =
            $this->service->suppliers();

        View::render(
            'admin/components/edit',
            [
                'title' =>
                    'Edit Component',

                'component' =>
                    $component,

                'suppliers' =>
                    $suppliers
            ]
        );
    }

    /**
     * Update Component
     */
    public function update(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid component ID.'
            );

            Response::redirect(
                '/admin/components'
            );

            return;
        }

        $result =
            $this->service->update(
                $id,
                $_POST
            );

        Session::flash(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );

        Response::redirect(
            '/admin/components'
        );
    }

    /**
     * Dispose Component
     */
    public function deactivate(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid component ID.'
            );

            Response::redirect(
                '/admin/components'
            );

            return;
        }

        $result =
            $this->service->deactivate(
                $id
            );

        Session::flash(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );

        Response::redirect(
            '/admin/components'
        );
    }
}