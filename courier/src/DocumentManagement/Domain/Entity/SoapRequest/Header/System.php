<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class System
{
    private string $applicationID;
    private string $transactionID;

    /**
     * @param string $applicationID
     * @param string $transactionID
     */
    public function __construct(string $applicationID, string $transactionID)
    {
        $this->applicationID = $applicationID;
        $this->transactionID = $transactionID;
    }

    public function getApplicationID(): string
    {
        return $this->applicationID;
    }

    public function setApplicationID(string $applicationID): void
    {
        $this->applicationID = $applicationID;
    }

    public function getTransactionID(): string
    {
        return $this->transactionID;
    }

    public function setTransactionID(string $transactionID): void
    {
        $this->transactionID = $transactionID;
    }
}