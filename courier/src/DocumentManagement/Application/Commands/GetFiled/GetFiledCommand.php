<?php

namespace App\DocumentManagement\Application\Commands\GetFiled;

use App\Shared\Domain\Command;

class GetFiledCommand implements Command
{
    private array $filed;
    public function __construct(){}

    public function getFiled(): array
    {
        return $this->filed;
    }

    public function setFiled(array $filed): void
    {
        $this->filed = $filed;
    }
}