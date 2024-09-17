<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Entity\Filed;

interface DocumentRepository
{
    function create(Document $document, Filed $filed): Document;
    function updatePathFile(string $documentId): void;
}