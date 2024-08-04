<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class RequestDTO
{
    public Security $Security;
    public System $System;

    /**
     * @param Security $security
     * @param System $system
     */
    public function __construct(Security $security, System $system)
    {
        $this->Security = $security;
        $this->System = $system;
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
        return $this->System;
    }

    public function setSystem(System $System): void
    {
        $this->System = $System;
    }


}