<?php

namespace App\Shared\Application\Commands\GetAllLogs;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Command;

class GetAllLogsCommand implements Command
{
    private ResponsePaginator $logs;
    private int $page;

    /**
     * @param int $page
     */
    public function __construct(int $page)
    {
        $this->page = $page;
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
}