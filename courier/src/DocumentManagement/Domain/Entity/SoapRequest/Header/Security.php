<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class Security
{
    private string $user;
    private string $password;

    /**
     * @param string $user
     * @param string $password
     */
    public function __construct(string $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}