<?php

namespace App\Shared\Application\Commands\GetLogById;

use App\Shared\Domain\Command;
use App\Shared\Domain\Log;

class GetLogByIdCommand implements Command
{

    /**
     * @var string
     */
    private string $type;

    /**
     * @var Log|null
     */
    private Log|null $log;

    /**
     * @var int
     */
    private int $id_log;

    /**
     * @param string $type
     * @param int $id_log
     */
    public function __construct(string $type, int $id_log)
    {
        $this->type = $type;
        $this->id_log = $id_log;
    }


    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getIdLog(): int
    {
        return $this->id_log;
    }

    public function setIdLog(int $id_log): void
    {
        $this->id_log = $id_log;
    }

    public function getLog(): ?Log
    {
        return $this->log;
    }

    public function setLog(?Log $log): void
    {
        $this->log = $log;
    }

}