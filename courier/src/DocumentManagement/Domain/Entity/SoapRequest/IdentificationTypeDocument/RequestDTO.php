<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class RequestDTO
{
    private ContextDTO $contexto;
    private DetailDTO $detalle;

    /**
     * @param ContextDTO $contexto
     * @param DetailDTO $detalle
     */
    public function __construct(ContextDTO $contexto, DetailDTO $detalle)
    {
        $this->contexto = $contexto;
        $this->detalle = $detalle;
    }

    public function getContexto(): ContextDTO
    {
        return $this->contexto;
    }

    public function setContexto(ContextDTO $contexto): void
    {
        $this->contexto = $contexto;
    }

    public function getDetalle(): DetailDTO
    {
        return $this->detalle;
    }

    public function setDetalle(DetailDTO $detalle): void
    {
        $this->detalle = $detalle;
    }
}