<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class RequestDTO
{
    public Contexto $Contexto;
    public Detalle $Detalle;

    /**
     * @param Contexto $contexto
     * @param Detalle $detalle
     */
    public function __construct(Contexto $contexto, Detalle $detalle)
    {
        $this->Contexto = $contexto;
        $this->Detalle = $detalle;
    }

    public function getContexto(): Contexto
    {
        return $this->Contexto;
    }

    public function setContexto(Contexto $Contexto): void
    {
        $this->Contexto = $Contexto;
    }

    public function getDetalle(): Detalle
    {
        return $this->Detalle;
    }

    public function setDetalle(Detalle $Detalle): void
    {
        $this->Detalle = $Detalle;
    }
}