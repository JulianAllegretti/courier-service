<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentFile;

use App\Shared\Domain\Command;

class GetDocumentFileCommand implements Command
{
    private string $documentId;

    /**
     * @param string $documentId
     */
    public function __construct(string $documentId)
    {
        $this->documentId = $documentId;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

}