<?php

namespace App\DocumentManagement\Application\Commands\GetFiledByHourAndDate;
use App\Shared\Domain\Command;

class GetFiledByHourAndDateCommand implements Command
{
    /**
     * @var array
     */
    private array $result;

    public function __construct()
    {
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function setResult(array $result): void
    {
        $this->result = $result;
    }
}