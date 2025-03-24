<?php

namespace App\Shared\Application\Commands\GetLogById;

use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use App\Shared\Domain\Repository\LogInsertInformationRepository;

readonly class GetLogByIdCommandHandler implements CommandHandler
{
    public function __construct(
        private LogGetDocumentFileRepository   $documentRepository,
        private LogInsertInformationRepository $repository
    )
    {
    }

    public function __invoke(GetLogByIdCommand $command): void
    {
        $command->setLog(
            $command->getType() == 'document' ?
                $this->documentRepository->getLogById($command->getIdLog()) :
                $this->repository->getLogById($command->getIdLog())
        );
    }
}