<?php

namespace App\Shared\Application\Commands\GetAllLogs;

use App\Shared\Domain\Command;

class GetAllLogsCommand implements Command
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