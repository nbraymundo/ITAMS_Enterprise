<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\EmployeeService;

class EmployeeController
{
    private EmployeeService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new EmployeeService();
        $this->request = new Request();
    }

    /**
     * List Employees
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $employees = $this->service->all(
            $search
        );

        View::render(
            'admin/employees/index',
            [
                'title' => 'Employees',

                'employees' => $employees,

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
        $jobTitles = $this->service->jobTitles();

        $departments = $this->service->departments();

        $locations = $this->service->locations();

        View::render(
            'admin/employees/create',
            [
                'title' => 'Add Employee',

                'jobTitles' => $jobTitles,

                'departments' => $departments,

                'locations' => $locations
            ]
        );
    }

    /**
     * Store Employee
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
                '/admin/employees/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/employees'
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
                'Invalid employee ID.'
            );

            Response::redirect(
                '/admin/employees'
            );
        }

        $employee = $this->service->find($id);

        if (!$employee) {

            Session::flash(
                'error',
                'Employee not found.'
            );

            Response::redirect(
                '/admin/employees'
            );
        }

        $jobTitles = $this->service->jobTitles();

        $departments = $this->service->departments();

        $locations = $this->service->locations();

        View::render(
            'admin/employees/edit',
            [
                'title' => 'Edit Employee',

                'employee' => $employee,

                'jobTitles' => $jobTitles,

                'departments' => $departments,

                'locations' => $locations
            ]
        );
    }

    /**
     * Update Employee
     */
    public function update(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

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
            '/admin/employees'
        );
    }

    /**
     * Deactivate Employee
     */
    public function deactivate(): void
    {
        $id = (int) (
            $_POST['id'] ?? 0
        );

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
            '/admin/employees'
        );
    }
}