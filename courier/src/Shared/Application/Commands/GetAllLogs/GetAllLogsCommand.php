<?php

namespace App\Shared\Application\Commands\GetAllLogs;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Command;

class GetAllLogsCommand implements Command
{
    private ResponsePaginator $logs;
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


    public function getLogs(): ResponsePaginator
    {
        return $this->logs;
    }

    public function setLogs(ResponsePaginator $logs): void
    {
        $this->logs = $logs;
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