<?php

namespace App\DocumentManagement\Application\Commands\GetFiledById;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogInsertInformationRepository;
use App\Shared\Infrastructure\Repository\LogGetDocumentFileMysqlRepository;

readonly class GetFiledByIdCommandHandler implements CommandHandler
{

    public function __construct(
        private FiledRepository $repository,
        private LogInsertInformationRepository $logRepository,
        private LogGetDocumentFileMysqlRepository $logDocumentRepository
    )
    {
    }

    public function __invoke(GetFiledByIdCommand $command): void
    {
        $filed = $this->repository->getFiledById($command->getIdFiled());
        $command->setFiled($filed);

        if (!isset($filed)){
            return;
        }

        $command->setLogsInsert($this->logRepository->getLogsByNumFiled($filed->getNumRadicado()));
        $command->setLogsGetDocuments($this->logDocumentRepository->getLogsByNumFiled($filed->getNumRadicado()));
    }
}