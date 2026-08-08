<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Paginator;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\BrandService;

class BrandController
{
    private BrandService $service;

    public function __construct()
    {
        $this->service = new BrandService();
    }

    /**
     * Brand List
     */
    public function index(): void
    {
        $request = new Request();

        $search = trim(
            (string)$request->get('search', '')
        );

        $page = max(
            1,
            (int)$request->get('page', 1)
        );

        $perPage = max(
            1,
            (int)$request->get('per_page', 10)
        );

        $total = $this->service->count($search);

        $paginator = new Paginator(
            $total,
            $page,
            $perPage
        );

        $brands = $this->service->all(
            $search,
            $paginator->limit(),
            $paginator->offset()
        );

        View::render(
            'admin/brands/index',
            [
                'title'       => 'Asset Brands',
                'brands'      => $brands,
                'search'      => $search,
                'pagination'  => $paginator,
                'success'     => $_SESSION['success'] ?? null,
                'error'       => $_SESSION['error'] ?? null,
            ]
        );

        unset($_SESSION['success'], $_SESSION['error']);
    }

    /**
     * Create Form
     */
    public function create(): void
    {
        View::render(
            'admin/brands/create',
            [
                'title' => 'Add Brand',
                'manufacturerList' => $this->service->manufacturerList(),
            ]
        );
    }

    /**
     * Save Brand
     */
    public function store(): void
    {
        $request = new Request();

        $result = $this->service->create([
            'brand_code'      => trim((string)$request->post('brand_code')),
            'brand_name'      => trim((string)$request->post('brand_name')),
            'manufacturer_id' => (int)$request->post('manufacturer_id'),
            'description'     => trim((string)$request->post('description')),
            'status'          => $request->post('status', 'Active'),
        ]);

        if (!$result['success']) {

            View::render(
                'admin/brands/create',
                [
                    'title' => 'Add Brand',
                    'error' => $result['message'],
                    'manufacturerList' => $this->service->manufacturerList(),
                    'brand' => $request->all(),
                ]
            );

            return;
        }

        $_SESSION['success'] = $result['message'];

        Response::redirect('/admin/brands');
    }

    /**
     * Edit Form
     */
    public function edit(): void
    {
        $request = new Request();

        $id = (int)$request->get('id');

        $brand = $this->service->find($id);

        if (!$brand) {

            $_SESSION['error'] = 'Brand not found.';

            Response::redirect('/admin/brands');
        }

        View::render(
            'admin/brands/edit',
            [
                'title' => 'Edit Brand',
                'brand' => $brand,
                'manufacturerList' => $this->service->manufacturerList(),
            ]
        );
    }

    /**
     * Update Brand
     */
    public function update(): void
    {
        $request = new Request();

        $id = (int)$request->post('id');

        $result = $this->service->update(
            $id,
            [
                'brand_code'      => trim((string)$request->post('brand_code')),
                'brand_name'      => trim((string)$request->post('brand_name')),
                'manufacturer_id' => (int)$request->post('manufacturer_id'),
                'description'     => trim((string)$request->post('description')),
                'status'          => $request->post('status', 'Active'),
            ]
        );

        if (!$result['success']) {

            $brand = $this->service->find($id);

            View::render(
                'admin/brands/edit',
                [
                    'title' => 'Edit Brand',
                    'error' => $result['message'],
                    'brand' => $brand,
                    'manufacturerList' => $this->service->manufacturerList(),
                ]
            );

            return;
        }

        $_SESSION['success'] = $result['message'];

        Response::redirect('/admin/brands');
    }

    /**
     * Deactivate Brand
     */
    public function deactivate(): void
    {
        $request = new Request();

        $id = (int)$request->post('id');

        $result = $this->service->deactivate($id);

        $_SESSION['success'] = $result['message'];

        Response::redirect('/admin/brands');
    }
}