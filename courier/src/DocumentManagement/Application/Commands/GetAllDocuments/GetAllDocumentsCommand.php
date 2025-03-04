<?php

namespace App\DocumentManagement\Application\Commands\GetAllDocuments;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Command;

class GetAllDocumentsCommand implements Command
{
    private ResponsePaginator $documents;
    private int $page;

    /**
     * @param int $page
     */
    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public function getDocuments(): ResponsePaginator
    {
        return $this->documents;
    }

    public function setDocuments(ResponsePaginator $documents): void
    {
        $this->documents = $documents;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

}