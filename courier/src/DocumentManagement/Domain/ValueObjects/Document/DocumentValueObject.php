<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

class DocumentValueObject
{
    private DocumentIdValueObject $documentId;
    private UrlSeeDocument $urlSeeDocument;

    /**
     * @param DocumentIdValueObject $documentId
     * @param UrlSeeDocument $endPointFileNet
     */
    public function __construct(DocumentIdValueObject $documentId, UrlSeeDocument $endPointFileNet)
    {
        $this->documentId = $documentId;
        $this->urlSeeDocument = $endPointFileNet;
    }

    public function getDocumentId(): DocumentIdValueObject
    {
        return $this->documentId;
    }

    public function getUrlSeeDocument(): UrlSeeDocument
    {
        return $this->urlSeeDocument;
    }

}