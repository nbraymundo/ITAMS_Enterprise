<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\CompanyService;

class CompanyController
{
    private CompanyService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new CompanyService();
        $this->request = new Request();
    }

    /**
     * List Companies
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $companies = $this->service->all(
            $search
        );

        View::render(
            'admin/companies/index',
            [
                'title' => 'Companies',

                'companies' => $companies,

                'search' => $search,

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
            'admin/companies/create',
            [
                'title' => 'Add Company'
            ]
        );
    }

    /**
     * Store Company
     */
    public function store(): void
    {
        $result = $this->service->create(
            $_POST
        );

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect(
                '/admin/companies/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/companies'
        );
    }

    /**
     * Edit Form
     */
    public function edit(): void
    {
        $id = (int) $this->request->get('id');

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid company ID.'
            );

            Response::redirect(
                '/admin/companies'
            );
        }

        $company = $this->service->find($id);

        if (!$company) {

            Session::flash(
                'error',
                'Company not found.'
            );

            Response::redirect(
                '/admin/companies'
            );
        }

        View::render(
            'admin/companies/edit',
            [
                'title' => 'Edit Company',

                'company' => $company
            ]
        );
    }

    /**
     * Update Company
     */
    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

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
            '/admin/companies'
        );
    }

    /**
     * Deactivate Company
     */
    public function deactivate(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $result = $this->service->deactivate(
            $id
        );

        Session::flash(
            $result['success']
                ? 'success'
                : 'error',
            $result['message']
        );

        Response::redirect(
            '/admin/companies'
        );
    }
}