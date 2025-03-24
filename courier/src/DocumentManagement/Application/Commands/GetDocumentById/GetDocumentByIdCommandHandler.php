<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentById;


use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;

readonly class GetDocumentByIdCommandHandler implements CommandHandler
{

    public function __construct(
        private DocumentRepository $repository,
        private LogGetDocumentFileRepository $logRepository
    )
    {
    }

    public function __invoke(GetDocumentByIdCommand $command): void
    {
        $document = $this->repository->getDocumentById($command->getDocumentId());
        $command->setDocument($document);
        if (!isset($document)) {
            return;
        }
        $command->setLogs($this->logRepository->getLogsByDocumentId($document->getIdGestorDocumento()));
    }

}