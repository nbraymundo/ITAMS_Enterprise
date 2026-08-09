<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JobTitle;

class JobTitleService
{
    private JobTitle $jobTitle;

    public function __construct()
    {
        $this->jobTitle = new JobTitle();
    }

    /**
     * Get all job titles
     */
    public function all(string $search = ''): array
    {
        return $this->jobTitle->all($search);
    }

    /**
     * Find job title
     */
    public function find(int $id): array|false
    {
        if ($id <= 0) {
            return false;
        }

        return $this->jobTitle->find($id);
    }

    /**
     * Get active job titles
     *
     * Used by Employee dropdowns.
     */
    public function active(): array
    {
        return $this->jobTitle->active();
    }

    /**
     * Create job title
     */
    public function create(array $data): array
    {
        $code = strtoupper(
            trim((string) ($data['job_title_code'] ?? ''))
        );

        $jobTitle = trim(
            (string) ($data['job_title'] ?? '')
        );

        $description = trim(
            (string) ($data['description'] ?? '')
        );

        $status = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($code === '') {
            return [
                'success' => false,
                'message' => 'Job Title Code is required.'
            ];
        }

        if ($jobTitle === '') {
            return [
                'success' => false,
                'message' => 'Job Title is required.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Code
        |--------------------------------------------------------------------------
        */

        if ($this->jobTitle->existsCode($code)) {
            return [
                'success' => false,
                'message' => 'Job Title Code already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Job Title
        |--------------------------------------------------------------------------
        */

        if ($this->jobTitle->existsName($jobTitle)) {
            return [
                'success' => false,
                'message' => 'Job Title already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Create
        |--------------------------------------------------------------------------
        */

        try {

            $result = $this->jobTitle->create([
                'job_title_code' => $code,
                'job_title' => $jobTitle,
                'description' => $description !== ''
                    ? $description
                    : null,
                'status' => $status
            ]);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to create Job Title.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Job Title created successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to create Job Title.'
            ];
        }
    }

    /**
     * Update job title
     */
    public function update(
        int $id,
        array $data
    ): array {

        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid Job Title ID.'
            ];
        }

        $existing = $this->jobTitle->find($id);

        if (!$existing) {
            return [
                'success' => false,
                'message' => 'Job Title not found.'
            ];
        }

        $code = strtoupper(
            trim((string) ($data['job_title_code'] ?? ''))
        );

        $jobTitle = trim(
            (string) ($data['job_title'] ?? '')
        );

        $description = trim(
            (string) ($data['description'] ?? '')
        );

        $status = (
            ($data['status'] ?? 'Active') === 'Inactive'
        )
            ? 'Inactive'
            : 'Active';

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if ($code === '') {
            return [
                'success' => false,
                'message' => 'Job Title Code is required.'
            ];
        }

        if ($jobTitle === '') {
            return [
                'success' => false,
                'message' => 'Job Title is required.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Code
        |--------------------------------------------------------------------------
        */

        if (
            $this->jobTitle->existsCode(
                $code,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Job Title Code already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate Job Title
        |--------------------------------------------------------------------------
        */

        if (
            $this->jobTitle->existsName(
                $jobTitle,
                $id
            )
        ) {
            return [
                'success' => false,
                'message' => 'Job Title already exists.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        try {

            $result = $this->jobTitle->update(
                $id,
                [
                    'job_title_code' => $code,
                    'job_title' => $jobTitle,
                    'description' => $description !== ''
                        ? $description
                        : null,
                    'status' => $status
                ]
            );

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to update Job Title.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Job Title updated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to update Job Title.'
            ];
        }
    }

    /**
     * Deactivate job title
     */
    public function deactivate(int $id): array
    {
        if ($id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid Job Title ID.'
            ];
        }

        $existing = $this->jobTitle->find($id);

        if (!$existing) {
            return [
                'success' => false,
                'message' => 'Job Title not found.'
            ];
        }

        if (($existing['status'] ?? '') === 'Inactive') {
            return [
                'success' => false,
                'message' => 'Job Title is already inactive.'
            ];
        }

        try {

            $result = $this->jobTitle->deactivate($id);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Unable to deactivate Job Title.'
                ];
            }

            return [
                'success' => true,
                'message' => 'Job Title deactivated successfully.'
            ];

        } catch (\Throwable $e) {

            return [
                'success' => false,
                'message' => 'Unable to deactivate Job Title.'
            ];
        }
    }
}