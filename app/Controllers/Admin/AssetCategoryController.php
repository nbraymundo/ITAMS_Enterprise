<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Paginator;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Middleware\AuthMiddleware;
use App\Services\AssetCategoryService;

class AssetCategoryController
{
    private AssetCategoryService $service;

    public function __construct()
    {
        $this->service = new AssetCategoryService();
    }

    /**
 * Asset Category List
 */
public function index(): void
{
    AuthMiddleware::handle();

    $request = new Request();

    $search = trim((string)$request->get('search', ''));

    $page = max(
        1,
        (int)$request->get('page', 1)
    );

    $perPage = max(
        1,
        (int)$request->get('per_page', 10)
    );

    $sort = (string)$request->get(
        'sort',
        'category_name'
    );

    $direction = strtoupper(
        (string)$request->get(
            'direction',
            'ASC'
        )
    );

    $totalRecords = $this->service->countAll($search);

    $paginator = new Paginator(
        $totalRecords,
        $page,
        $perPage
    );

    $categories = $this->service->all(
        $search,
        $page,
        $perPage,
        $sort,
        $direction
    );

    View::render(
        'admin/asset-categories/index',
        [
            'title'       => 'Asset Categories',
            'categories'  => $categories,
            'search'      => $search,
            'perPage'     => $perPage,
            'sort'        => $sort,
            'direction'   => $direction,
            'paginator'   => $paginator,
            'success'     => Session::getFlash('success'),
            'error'       => Session::getFlash('error')
        ]
    );
}

    /**
     * Create Form
     */
    public function create(): void
    {
        AuthMiddleware::handle();

        View::render(
            'admin/asset-categories/create',
            [
                'title' => 'Add Asset Category'
            ]
        );
    }

    /**
     * Store
     */
    public function store(): void
    {
        AuthMiddleware::handle();

        $request = new Request();

        $result = $this->service->create([
            'category_code' => strtoupper(trim((string) $request->post('category_code'))),
            'category_name' => trim((string) $request->post('category_name')),
            'description'   => trim((string) $request->post('description')),
            'icon'          => trim((string) $request->post('icon')),
            'color'         => trim((string) $request->post('color')),
            'sort_order'    => (int) $request->post('sort_order'),
            'status'        => (string) $request->post('status')
        ]);

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect('/admin/asset-categories/create');
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect('/admin/asset-categories');
    }

    /**
     * Edit
     */
    public function edit(): void
    {
        AuthMiddleware::handle();

        $request = new Request();

        $id = (int) $request->get('id');

        $category = $this->service->find($id);

        if (!$category) {

            Session::flash(
                'error',
                'Category not found.'
            );

            Response::redirect('/admin/asset-categories');
        }

        View::render(
            'admin/asset-categories/edit',
            [
                'title'    => 'Edit Asset Category',
                'category' => $category
            ]
        );
    }

    /**
     * Update
     */
    public function update(): void
    {
        AuthMiddleware::handle();

        $request = new Request();

        $id = (int) $request->post('id');

        $result = $this->service->update(
            $id,
            [
                'category_code' => strtoupper(trim((string) $request->post('category_code'))),
                'category_name' => trim((string) $request->post('category_name')),
                'description'   => trim((string) $request->post('description')),
                'icon'          => trim((string) $request->post('icon')),
                'color'         => trim((string) $request->post('color')),
                'sort_order'    => (int) $request->post('sort_order'),
                'status'        => (string) $request->post('status')
            ]
        );

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect('/admin/asset-categories/edit?id=' . $id);
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect('/admin/asset-categories');
    }

    /**
     * Deactivate
     */
    public function deactivate(): void
    {
        AuthMiddleware::handle();

        $request = new Request();

        $id = (int) $request->post('id');

        $result = $this->service->deactivate($id);

        if (!$result['success']) {

            Session::flash(
                'error',
                $result['message']
            );

            Response::redirect('/admin/asset-categories');
        }

        Session::flash(
            'success',
            $result['message']
        );

        Response::redirect('/admin/asset-categories');
    }
}