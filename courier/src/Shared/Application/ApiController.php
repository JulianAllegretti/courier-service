<?php

namespace App\Shared\Application;

use App\Shared\Domain\Command;
use App\Shared\Domain\CommandBus;

class ApiController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {}

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}