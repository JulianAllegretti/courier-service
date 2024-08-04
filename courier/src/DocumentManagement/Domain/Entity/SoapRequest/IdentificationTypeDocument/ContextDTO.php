<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class ContextDTO
{
    public string $NombreUsuarioNegocio;
    public string $NombreUsuarioSistema;
    public string $ClaveUsuarioSistema;

    /**
     * @param string $nombreUsuarioNegocio
     * @param string $nombreUsuarioSistema
     * @param string $claveUsuarioSistema
     */
    public function __construct(string $nombreUsuarioNegocio, string $nombreUsuarioSistema, string $claveUsuarioSistema)
    {
        $this->NombreUsuarioNegocio = $nombreUsuarioNegocio;
        $this->NombreUsuarioSistema = $nombreUsuarioSistema;
        $this->ClaveUsuarioSistema = $claveUsuarioSistema;
    }

    public function getNombreUsuarioNegocio(): string
    {
        return $this->NombreUsuarioNegocio;
    }

    public function setNombreUsuarioNegocio(string $NombreUsuarioNegocio): void
    {
        $this->NombreUsuarioNegocio = $NombreUsuarioNegocio;
    }

    public function getNombreUsuarioSistema(): string
    {
        return $this->NombreUsuarioSistema;
    }

    public function setNombreUsuarioSistema(string $NombreUsuarioSistema): void
    {
        $this->NombreUsuarioSistema = $NombreUsuarioSistema;
    }

    public function getClaveUsuarioSistema(): string
    {
        return $this->ClaveUsuarioSistema;
    }

    public function setClaveUsuarioSistema(string $ClaveUsuarioSistema): void
    {
        $this->ClaveUsuarioSistema = $ClaveUsuarioSistema;
    }
}