<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentById;


use App\DocumentManagement\Domain\Entity\Document;
use App\Shared\Domain\Command;

class GetDocumentByIdCommand implements Command
{
    /**
     * @var string
     */
    private string $documentId;

    /**
     * @var Document|null
     */
    private Document|null $document;

    /**
     * @var array
     */
    private array $logs;

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

    public function setDocumentId(string $documentId): void
    {
        $this->documentId = $documentId;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): void
    {
        $this->document = $document;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function setLogs(array $logs): void
    {
        $this->logs = $logs;
    }

}