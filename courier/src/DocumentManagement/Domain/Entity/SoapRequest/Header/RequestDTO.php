<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class RequestDTO
{
    public Security $Security;
    public System $system;

    /**
     * @param Security $security
     * @param System $system
     */
    public function __construct(Security $security, System $system)
    {
        $this->Security = $security;
        $this->system = $system;
    }

    public function getSecurity(): Security
    {
        return $this->Security;
    }

    public function setSecurity(Security $Security): void
    {
        $this->Security = $Security;
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