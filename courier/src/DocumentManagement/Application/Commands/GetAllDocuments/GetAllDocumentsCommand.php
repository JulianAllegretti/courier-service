<?php

namespace App\DocumentManagement\Application\Commands\GetAllDocuments;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Command;

class GetAllDocumentsCommand implements Command
{
    private ResponsePaginator $documents;
    private int $page;

    private array $params;

    /**
     * @param int $page
     * @param array $params
     */
    public function __construct(int $page, array $params)
    {
        $this->page = $page;
        $this->params = $params;
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

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

}