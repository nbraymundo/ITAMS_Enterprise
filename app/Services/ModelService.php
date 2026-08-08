<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Model;

class ModelService
{
    private Model $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    /**
     * List models
     */
    public function all(
        string $search = '',
        int $limit = 10,
        int $offset = 0
    ): array {
        return $this->model->all(
            $search,
            $limit,
            $offset
        );
    }

    /**
     * Total records
     */
    public function count(string $search = ''): int
    {
        return $this->model->count($search);
    }

    /**
     * Find one model
     */
    public function find(int $id): array|false
    {
        return $this->model->find($id);
    }

    /**
     * Brand dropdown
     */
    public function brands(): array
    {
        return $this->model->brands();
    }

    /**
     * Create model
     */
    public function create(array $data): bool
    {
        return $this->model->create($data);
    }

    /**
     * Update model
     */
    public function update(
        int $id,
        array $data
    ): bool {
        return $this->model->update(
            $id,
            $data
        );
    }

    /**
     * Deactivate model
     */
    public function deactivate(int $id): bool
    {
        return $this->model->deactivate($id);
    }

    /**
     * Code already exists
     */
    public function existsCode(string $code): bool
    {
        return $this->model->existsCode($code);
    }

    /**
     * Name already exists
     */
    public function existsName(string $name): bool
    {
        return $this->model->existsName($name);
    }
}