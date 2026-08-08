<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\LocationService;

class LocationController
{
    private LocationService $service;
    private Request $request;

    public function __construct()
    {
        $this->service = new LocationService();
        $this->request = new Request();
    }

    /**
     * List Locations
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $locations = $this->service->all(
            $search
        );

        View::render(
            'admin/locations/index',
            [
                'title' => 'Locations',

                'locations' => $locations,

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
        $branches = $this->service->branches();

        View::render(
            'admin/locations/create',
            [
                'title' => 'Add Location',

                'branches' => $branches
            ]
        );
    }

    /**
     * Store Location
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
                '/admin/locations/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/locations'
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
                'Invalid location ID.'
            );

            Response::redirect(
                '/admin/locations'
            );
        }

        $location = $this->service->find($id);

        if (!$location) {

            Session::flash(
                'error',
                'Location not found.'
            );

            Response::redirect(
                '/admin/locations'
            );
        }

        $branches = $this->service->branches();

        View::render(
            'admin/locations/edit',
            [
                'title' => 'Edit Location',

                'location' => $location,

                'branches' => $branches
            ]
        );
    }

    /**
     * Update Location
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
            '/admin/locations'
        );
    }

    /**
     * Deactivate Location
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
            '/admin/locations'
        );
    }
}