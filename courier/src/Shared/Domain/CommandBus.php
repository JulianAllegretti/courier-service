<?php

namespace App\Shared\Domain;

interface CommandBus
{
    public function dispatch(Command $command): void;
}