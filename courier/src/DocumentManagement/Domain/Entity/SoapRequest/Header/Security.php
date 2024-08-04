<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\Header;

use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;

class Security
{
    public string $User;
    public string $Password;

    /**
     * @param string $user
     * @param string $password
     */
    public function __construct(string $user, string $password)
    {
        $this->User = $user;
        $this->Password = $password;
    }

    public function getUser(): string
    {
        return $this->User;
    }

    public function setUser(string $User): void
    {
        $this->User = $User;
    }

    public function getPassword(): string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }


}