<?php

namespace App\Shared\Application\Commands\GetAllLogsDocuments;

use App\Shared\Domain\Command;

class GetAllLogsDocumentsCommand implements Command
{
    private array $logs;

    public function __construct()
    {
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function setLogs(array $logs): void
    {
        $this->logs = $logs;
    }

}