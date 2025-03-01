<?php

namespace App\Shared\Application\Commands\GetAllLogsDocuments;

use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;

readonly class GetAllLogsDocumentsCommandHandler implements CommandHandler
{
    public function __construct(private LogGetDocumentFileRepository $repository)
    {
    }

    public function __invoke(GetAllLogsDocumentsCommand $command): void
    {
        $command->setLogs($this->repository->getAllLogs());
    }
}