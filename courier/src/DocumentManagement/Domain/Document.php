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
    public $endPointFileNet;

    /**
     * @var int
     */
    public $ordenImp;

    /**
     * @var int
     */
    public $numPaginas;

    /**
     * @var string|null
     */
    public $nombreArchivo;

    public function __construct(?string $documentId, ?string $endPointFileNet, ?int $ordenImp, ?int $numPaginas, ?string $nombreArchivo = null)
    {
        $this->idDocumento = $documentId;
        $this->endPointFileNet = $endPointFileNet;
        $this->ordenImp = $ordenImp;
        $this->numPaginas = $numPaginas;
        $this->nombreArchivo = $nombreArchivo;
    }

    public function getIdDocumento(): ?string
    {
        return $this->idDocumento;
    }

    public function getEndPointFileNet(): ?string
    {
        return $this->endPointFileNet;
    }

    public function getOrdenImp(): ?int
    {
        return $this->ordenImp;
    }

    public function getNumPaginas(): ?int
    {
        return $this->numPaginas;
    }

    public function getNombreArchivo(): ?string
    {
        return $this->nombreArchivo;
    }



}