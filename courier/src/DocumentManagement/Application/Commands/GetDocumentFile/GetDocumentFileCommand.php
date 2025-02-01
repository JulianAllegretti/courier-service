<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentFile;

use App\Shared\Domain\Command;

class GetDocumentFileCommand implements Command
{
    private string $documentId;
    private string $guideNumber;

    /**
     * @param string $documentId
     * @param string $guideNumber
     */
    public function __construct(string $documentId, string $guideNumber)
    {
        $this->documentId = $documentId;
        $this->guideNumber = $guideNumber;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function getGuideNumber(): string
    {
        return $this->guideNumber;
    }

}