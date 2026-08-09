<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\JobTitleService;

class JobTitleController
{
    private JobTitleService $service;

    private Request $request;

    public function __construct()
    {
        $this->service = new JobTitleService();

        $this->request = new Request();
    }

    /**
     * List Job Titles
     */
    public function index(): void
    {
        $search = trim(
            $this->request->get('search', '')
        );

        $jobTitles = $this->service->all(
            $search
        );

        View::render(
            'admin/job-titles/index',
            [
                'title' => 'Job Titles',

                'jobTitles' => $jobTitles,

                'search' => $search,

                'success' => Session::getFlash(
                    'success'
                ),

                'error' => Session::getFlash(
                    'error'
                )
            ]
        );
    }

    /**
     * Create Form
     */
    public function create(): void
    {
        View::render(
            'admin/job-titles/create',
            [
                'title' => 'Add Job Title'
            ]
        );
    }

    /**
     * Store Job Title
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
                '/admin/job-titles/create'
            );
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect(
            '/admin/job-titles'
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
                'Invalid Job Title ID.'
            );

            Response::redirect(
                '/admin/job-titles'
            );
        }

        $jobTitle = $this->service->find(
            $id
        );

        if (!$jobTitle) {

            Session::flash(
                'error',
                'Job Title not found.'
            );

            Response::redirect(
                '/admin/job-titles'
            );
        }

        View::render(
            'admin/job-titles/edit',
            [
                'title' => 'Edit Job Title',

                'jobTitle' => $jobTitle
            ]
        );
    }

    /**
     * Update Job Title
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
            '/admin/job-titles'
        );
    }

    /**
     * Deactivate Job Title
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
            '/admin/job-titles'
        );
    }
}