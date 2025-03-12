<?php

namespace App\DocumentManagement\Application\Commands\GetAllDocuments;

use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\Shared\Domain\CommandHandler;

readonly class GetAllDocumentsCommandHandler implements CommandHandler
{
    public function __construct(private DocumentRepository $repository)
    {
    }

    public function __invoke(GetAllDocumentsCommand $command): void
    {
        $command->setDocuments($this->repository->getAllDocuments($command->getPage(), $command->getParams()));
    }
}