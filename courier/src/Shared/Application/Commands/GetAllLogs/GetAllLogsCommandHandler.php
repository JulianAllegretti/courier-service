<?php

namespace App\Shared\Application\Commands\GetAllLogs;

use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogInsertInformationRepository;

readonly class GetAllLogsCommandHandler implements CommandHandler
{
    public function __construct(private LogInsertInformationRepository $repository)
    {
    }

    public function __invoke(GetAllLogsCommand $command): void
    {
        $command->setLogs($this->repository->getAllLogs());
    }
}