<?php

namespace App\Shared\Application\Creators;

use App\DocumentManagement\Domain\ValueObjects\Document\DocumentIdValueObject;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\Shared\Domain\Entity\LogGetDocumentFile;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use App\Shared\Domain\ValueObjects\ErrorValueObject;
use App\Shared\Domain\ValueObjects\RequestValueObject;

class LogGetDocumentCreator
{

    public function __construct(private LogGetDocumentFileRepository $repository)
    {}

    public function __invoke(FiledNumberValueObject $filedNumber, DocumentIdValueObject $documentId, RequestValueObject $request, ErrorValueObject $error): void
    {
        $log = new LogGetDocumentFile(
            null, $filedNumber->getValue(), $documentId->getValue(), $request->getValue(), $error->getValue()
        );
        $this->repository->create($log);
    }

}