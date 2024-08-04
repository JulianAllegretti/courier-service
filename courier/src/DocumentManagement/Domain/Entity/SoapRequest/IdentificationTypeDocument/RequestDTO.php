<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class RequestDTO
{
    private ContextDTO $Contexto;
    private DetailDTO $Detalle;

    /**
     * @param ContextDTO $contexto
     * @param DetailDTO $detalle
     */
    public function __construct(ContextDTO $contexto, DetailDTO $detalle)
    {
        $this->Contexto = $contexto;
        $this->Detalle = $detalle;
    }

    public function getContexto(): ContextDTO
    {
        return $this->Contexto;
    }

    public function setContexto(ContextDTO $Contexto): void
    {
        $this->Contexto = $Contexto;
    }

    public function getDetalle(): DetailDTO
    {
        return $this->Detalle;
    }

    public function setDetalle(DetailDTO $Detalle): void
    {
        $this->Detalle = $Detalle;
    }
}