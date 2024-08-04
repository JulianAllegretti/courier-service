<?php

namespace App\Shared\Application\Commands\CreateLogGetDocumentFile;

use App\Shared\Domain\Command;

readonly class CreateLogGetDocumentFileCommand implements Command
{
    public function __construct(private string $filedNumber, private string $documentId, private string $request, private string $error)
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

    public function getDocumentId(): string
    {
        return $this->documentId;
    }


}