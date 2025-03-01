<?php

namespace App\DocumentManagement\Application\Commands\GetAllDocuments;

use App\Shared\Domain\Command;

class GetAllDocumentsCommand implements Command
{
    private array $documents;
    public function __construct(){}

    public function getDocuments(): array
    {
        return $this->documents;
    }

    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }
}