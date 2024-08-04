<?php

namespace App\DocumentManagement\Domain;

use App\DocumentManagement\Domain\Enums\DocumentType;

class Identification
{
    /**
     * @var string
     */
    public $documento;
    /**
     * @var string
     */
    public $tipoDocumento;
    private DocumentType $documentTypeEnum;

    public function __construct(string $document, string $documentType)
    {
        $this->documento = $document;
        $this->tipoDocumento = $documentType;
        $this->documentTypeEnum = DocumentType::fromName($documentType);
    }

    public function getDocumento(): string
    {
        return $this->documento;
    }

    public function getTipoDocumento(): string
    {
        return $this->tipoDocumento;
    }

    public function getDocumentTypeEnum(): DocumentType
    {
        return $this->documentTypeEnum;
    }


}