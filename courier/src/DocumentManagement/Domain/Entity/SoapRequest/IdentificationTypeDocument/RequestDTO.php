<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class RequestDTO
{
    private ContextDTO $contexto;
    private Request $detalle;

    /**
     * @param ContextDTO $contexto
     * @param Request $detalle
     */
    public function __construct(ContextDTO $contexto, Request $detalle)
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

    public function getDetalle(): Request
    {
        return $this->detalle;
    }

    public function setDetalle(Request $detalle): void
    {
        $this->detalle = $detalle;
    }
}