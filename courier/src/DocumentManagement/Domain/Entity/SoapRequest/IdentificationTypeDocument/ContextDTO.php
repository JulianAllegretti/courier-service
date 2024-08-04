<?php

namespace App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument;

class ContextDTO
{
    private string $nombreUsuarioNegocio;
    private string $nombreUsuarioSistema;
    private string $claveUsuarioSistema;

    /**
     * @param string $nombreUsuarioNegocio
     * @param string $nombreUsuarioSistema
     * @param string $claveUsuarioSistema
     */
    public function __construct(string $nombreUsuarioNegocio, string $nombreUsuarioSistema, string $claveUsuarioSistema)
    {
        $this->nombreUsuarioNegocio = $nombreUsuarioNegocio;
        $this->nombreUsuarioSistema = $nombreUsuarioSistema;
        $this->claveUsuarioSistema = $claveUsuarioSistema;
    }

    public function getNombreUsuarioNegocio(): string
    {
        return $this->nombreUsuarioNegocio;
    }

    public function setNombreUsuarioNegocio(string $nombreUsuarioNegocio): void
    {
        $this->nombreUsuarioNegocio = $nombreUsuarioNegocio;
    }

    public function getNombreUsuarioSistema(): string
    {
        return $this->nombreUsuarioSistema;
    }

    public function setNombreUsuarioSistema(string $nombreUsuarioSistema): void
    {
        $this->nombreUsuarioSistema = $nombreUsuarioSistema;
    }

    public function getClaveUsuarioSistema(): string
    {
        return $this->claveUsuarioSistema;
    }

    public function setClaveUsuarioSistema(string $claveUsuarioSistema): void
    {
        $this->claveUsuarioSistema = $claveUsuarioSistema;
    }
}