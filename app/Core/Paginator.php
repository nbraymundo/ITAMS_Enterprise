<?php

declare(strict_types=1);

namespace App\Core;

class Paginator
{
    private int $totalRecords;
    private int $currentPage;
    private int $perPage;

    public function __construct(
        int $totalRecords,
        int $currentPage = 1,
        int $perPage = 10
    ) {
        $this->totalRecords = max(0, $totalRecords);
        $this->currentPage  = max(1, $currentPage);
        $this->perPage      = max(1, $perPage);
    }

    /**
     * Total Pages
     */
    public function totalPages(): int
    {
        return max(
            1,
            (int) ceil($this->totalRecords / $this->perPage)
        );
    }

    /**
     * SQL OFFSET
     */
    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * SQL LIMIT
     */
    public function limit(): int
    {
        return $this->perPage;
    }

    /**
     * Current Page
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Previous Page
     */
    public function previousPage(): int
    {
        return max(
            1,
            $this->currentPage - 1
        );
    }

    /**
     * Next Page
     */
    public function nextPage(): int
    {
        return min(
            $this->totalPages(),
            $this->currentPage + 1
        );
    }

    /**
     * Has Previous
     */
    public function hasPrevious(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * Has Next
     */
    public function hasNext(): bool
    {
        return $this->currentPage < $this->totalPages();
    }

    /**
     * Total Records
     */
    public function totalRecords(): int
    {
        return $this->totalRecords;
    }

    /**
     * Per Page
     */
    public function perPage(): int
    {
        return $this->perPage;
    }
}