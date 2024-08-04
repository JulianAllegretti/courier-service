<?php

namespace App\DocumentManagement\Domain\ValueObjects\Identification;

use App\DocumentManagement\Domain\Enums\DocumentType;

class IdentificationValueObject
{
    private DocumentNumberValueObject $document;
    private DocumentType $documentType;

    public function __construct(DocumentNumberValueObject $document, DocumentType $documentType)
    {
        $this->document = $document;
        $this->documentType = $documentType;
    }

    public function getDocument(): DocumentNumberValueObject
    {
        return $this->document;
    }

    public function getDocumentType(): DocumentType
    {
        return $this->documentType;
    }

}