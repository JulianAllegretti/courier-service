<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Contexto;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class System
{
    private string $ApplicationID;
    private string $TransactionID;

    /**
     * @param string $applicationID
     * @param string $transactionID
     */
    public function __construct(string $applicationID, string $transactionID)
    {
        $this->ApplicationID = $applicationID;
        $this->TransactionID = $transactionID;
    }

    public function getApplicationID(): string
    {
        return $this->ApplicationID;
    }

    public function setApplicationID(string $ApplicationID): void
    {
        $this->ApplicationID = $ApplicationID;
    }

    public function getTransactionID(): string
    {
        return $this->TransactionID;
    }

    public function setTransactionID(string $TransactionID): void
    {
        $this->TransactionID = $TransactionID;
    }
}