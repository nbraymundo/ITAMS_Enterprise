<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Core\Paginator;
use App\Services\ManufacturerService;

class ManufacturerController
{
    private ManufacturerService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new ManufacturerService();
        $this->request = new Request();
    }

    /**
     * List Manufacturers
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

        $manufacturers = $this->service->all(
            $search,
            $paginator->limit(),
            $paginator->offset()
        );

        View::render(
            'admin/manufacturers/index',
            [
                'title' => 'Manufacturers',

                'manufacturers' => $manufacturers,

                'search' => $search,

                'perPage' => $perPage,

                'pagination' => $paginator,

                'success' => Session::getFlash('success'),

                'error' => Session::getFlash('error')
            ]
        );
    }

    /**
     * Create Form
     */
    public function create(): void
    {
        View::render(
            'admin/manufacturers/create',
            [
                'title' => 'Add Manufacturer'
            ]
        );
    }

    /**
     * Store Manufacturer
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
                '/admin/manufacturers/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/manufacturers'
        );
    }

    /**
     * Edit Form
     */
    public function edit(): void
    {
        $id = (int) $this->request->get('id');

        $manufacturer = $this->service->find($id);

        if (!$manufacturer) {

            Session::flash(
                'error',
                'Manufacturer not found.'
            );

            Response::redirect(
                '/admin/manufacturers'
            );
        }

        View::render(
            'admin/manufacturers/edit',
            [
                'title' => 'Edit Manufacturer',

                'manufacturer' => $manufacturer
            ]
        );
    }

    /**
     * Update Manufacturer
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
            '/admin/manufacturers'
        );
    }

    /**
     * Deactivate Manufacturer
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
            '/admin/manufacturers'
        );
    }
}