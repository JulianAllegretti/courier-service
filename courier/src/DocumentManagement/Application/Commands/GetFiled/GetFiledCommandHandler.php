<?php

namespace App\DocumentManagement\Application\Commands\GetFiled;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Domain\CommandHandler;

readonly class GetFiledCommandHandler implements CommandHandler
{

    public function __construct(private FiledRepository $repository)
    {
    }

    public function __invoke(GetFiledCommand $command): void
    {
        $command->setFiled($this->repository->getAllFiled($command->getPage(), $command->getParams()));
    }
}