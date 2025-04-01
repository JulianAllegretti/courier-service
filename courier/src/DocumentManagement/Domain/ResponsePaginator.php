<?php

namespace App\DocumentManagement\Domain;

use Doctrine\ORM\Tools\Pagination\Paginator;

class ResponsePaginator
{
    /**
     * @var Paginator
     */
    public Paginator $paginator;
    /**
     * @var int
     */
    public int $totalPages;

    /**
     * @param Paginator $paginator
     * @param int $totalPages
     */
    public function __construct(Paginator $paginator, int $totalPages)
    {
        $this->paginator = $paginator;
        $this->totalPages = $totalPages;
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function setPaginator(Paginator $paginator): void
    {
        $this->paginator = $paginator;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }
}