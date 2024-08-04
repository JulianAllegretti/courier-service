<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class Detalle
{
    private string $Id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->Id = $id;
    }

    public function getId(): string
    {
        return $this->Id;
    }

    public function setId(string $Id): void
    {
        $this->Id = $Id;
    }
}