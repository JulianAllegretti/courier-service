<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class RequestDTO
{
    private Security $security;
    private System $system;

    /**
     * @param Security $security
     * @param System $system
     */
    public function __construct(Security $security, System $system)
    {
        $this->security = $security;
        $this->system = $system;
    }

    public function getSecurity(): Security
    {
        return $this->security;
    }

    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }

    public function getSystem(): System
    {
        return $this->system;
    }

    public function setSystem(System $system): void
    {
        $this->system = $system;
    }


}