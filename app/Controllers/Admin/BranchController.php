<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\BranchService;

class BranchController
{
    private BranchService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new BranchService();
        $this->request = new Request();
    }

    /**
     * List Branches
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $branches = $this->service->all(
            $search
        );

        View::render(
            'admin/branches/index',
            [
                'title' => 'Branches',

                'branches' => $branches,

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
        $companies = $this->service->companies();

        View::render(
            'admin/branches/create',
            [
                'title' => 'Add Branch',

                'companies' => $companies
            ]
        );
    }

    /**
     * Store Branch
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
                '/admin/branches/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/branches'
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
                'Invalid branch ID.'
            );

            Response::redirect(
                '/admin/branches'
            );
        }

        $branch = $this->service->find($id);

        if (!$branch) {

            Session::flash(
                'error',
                'Branch not found.'
            );

            Response::redirect(
                '/admin/branches'
            );
        }

        $companies = $this->service->companies();

        View::render(
            'admin/branches/edit',
            [
                'title' => 'Edit Branch',

                'branch' => $branch,

                'companies' => $companies
            ]
        );
    }

    /**
     * Update Branch
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
            '/admin/branches'
        );
    }

    /**
     * Deactivate Branch
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
            '/admin/branches'
        );
    }
}