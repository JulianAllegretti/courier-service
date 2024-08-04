<?php

namespace App\Shared\Application\Commands\CreateLogInsertInformation;

use App\Shared\Domain\Command;

readonly class CreateLogInsertInformationCommand implements Command
{
    public function __construct(private string $filedNumber, private string $request, private string $error)
    {
    }

    public function getFiledNumber(): string
    {
        return $this->filedNumber;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getError(): string
    {
        return $this->error;
    }
}