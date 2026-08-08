<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Paginator;
use App\Services\ModelService;

class ModelController
{
    private ModelService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new ModelService();
        $this->request = new Request();
    }

    /**
     * List Asset Models
     */
    public function index(): void
    {
        $search = trim($this->request->get('search', ''));

        $page = (int) $this->request->get('page', 1);

        $perPage = (int) $this->request->get('per_page', 10);

        if ($perPage <= 0) {
            $perPage = 10;
        }

        $total = $this->service->count($search);

        $paginator = new Paginator(
            $total,
            $page,
            $perPage
        );

        $models = $this->service->all(
            $search,
            $paginator->limit(),
            $paginator->offset()
        );

        View::render(
            'admin/models/index',
            [
                'title'      => 'Asset Models',
                'models'     => $models,
                'search'     => $search,
                'perPage'    => $perPage,
                'pagination' => $paginator,
                'success'    => Session::getFlash('success'),
                'error'      => Session::getFlash('error')
            ]
        );
    }

    /**
     * Create Form
     */
    public function create(): void
    {
        View::render(
            'admin/models/create',
            [
                'title'  => 'Add Asset Model',
                'brands' => $this->service->brands()
            ]
        );
    }

    /**
     * Store Model
     */
    public function store(): void
    {
        $result = $this->service->create($_POST);

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect(
                '/admin/models/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/models'
        );
    }

    /**
     * Edit Form
     */
    public function edit(): void
    {
        $id = (int) $this->request->get('id');

        $model = $this->service->find($id);

        if (!$model) {

            Session::flash(
                'error',
                'Asset Model not found.'
            );

            Response::redirect(
                '/admin/models'
            );
        }

        View::render(
            'admin/models/edit',
            [
                'title'  => 'Edit Asset Model',
                'model'  => $model,
                'brands' => $this->service->brands()
            ]
        );
    }

    /**
     * Update Model
     */
    public function update(): void
    {
        $id = (int) $_POST['id'];

        $result = $this->service->update(
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
            '/admin/models'
        );
    }

    /**
     * Deactivate Model
     */
    public function deactivate(): void
    {
        $id = (int) $_POST['id'];

        $result = $this->service->deactivate($id);

        Session::flash(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );

        Response::redirect(
            '/admin/models'
        );
    }
}