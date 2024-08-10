<?php

namespace App\DocumentManagement\Domain;

class Document
{
    /**
     * @var string
     */
    public $idDocumento;

    /**
     * @var string
     */
    public $urlVerDocumento;

    /**
     * @param string $idDocumento
     * @param string $urlVerDocumento
     */
    public function __construct(string $idDocumento, string $urlVerDocumento)
    {
        $this->idDocumento = $idDocumento;
        $this->urlVerDocumento = $urlVerDocumento;
    }

    public function getIdDocumento(): string
    {
        return $this->idDocumento;
    }

    public function getUrlVerDocumento(): string
    {
        return $this->urlVerDocumento;
    }

}