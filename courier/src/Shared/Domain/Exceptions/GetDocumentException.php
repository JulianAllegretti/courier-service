<?php

namespace App\Shared\Domain\Exceptions;

class GetDocumentException extends \Exception
{
    protected $code = 'C-E-500';
    protected string $documentId;

    public function setDocumentId(string $documentId): void
    {
        $this->documentId = $documentId;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

}