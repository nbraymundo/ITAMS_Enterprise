<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\DepartmentService;

class DepartmentController
{
    private DepartmentService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new DepartmentService();
        $this->request = new Request();
    }

    /**
     * List Departments
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $departments = $this->service->all(
            $search
        );

        View::render(
            'admin/departments/index',
            [
                'title' => 'Departments',

                'departments' => $departments,

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
            'admin/departments/create',
            [
                'title' => 'Add Department'
            ]
        );
    }

    /**
     * Store Department
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
                '/admin/departments/create'
            );

            return;
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/departments'
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
                'Invalid department ID.'
            );

            Response::redirect(
                '/admin/departments'
            );

            return;
        }

        $department = $this->service->find($id);

        if (!$department) {

            Session::flash(
                'error',
                'Department not found.'
            );

            Response::redirect(
                '/admin/departments'
            );

            return;
        }

        View::render(
            'admin/departments/edit',
            [
                'title' => 'Edit Department',

                'department' => $department
            ]
        );
    }

    /**
     * Update Department
     */
    public function update(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid department ID.'
            );

            Response::redirect(
                '/admin/departments'
            );

            return;
        }

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
            '/admin/departments'
        );
    }

    /**
     * Deactivate Department
     */
    public function deactivate(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

        if ($id <= 0) {

            Session::flash(
                'error',
                'Invalid department ID.'
            );

            Response::redirect(
                '/admin/departments'
            );

            return;
        }

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
            '/admin/departments'
        );
    }
}