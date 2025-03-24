<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Document;
use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\ResponsePaginator;

interface DocumentRepository
{
    function create(Document $document, Filed $filed): Document;
    function updatePathFile(string $documentId, string $guideNumber): void;
    function getAllDocuments(int $page, array $params): ResponsePaginator;
    function getDocumentById(int $documentId): Document|null;
}