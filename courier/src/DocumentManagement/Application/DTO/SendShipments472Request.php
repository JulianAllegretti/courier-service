<?php

namespace App\DocumentManagement\Application\DTO;

class SendShipments472Request
{
    private string $guia;
    private string $nombreDestinatario;
    private string $direccionDestinatario;
    private string $ciudadDestinatario;
    private string $departamentoDestinatario;
    private string $referencia;
    private string $observacion;
    private string $centroOperativo;

    /**
     * @param string $guia
     * @param string $nombreDestinatario
     * @param string $direccionDestinatario
     * @param string $ciudadDestinatario
     * @param string $departamentoDestinatario
     * @param string $referencia
     * @param string $observacion
     * @param string $centroOperativo
     */
    public function __construct(string $guia, string $nombreDestinatario, string $direccionDestinatario, string $ciudadDestinatario, string $departamentoDestinatario, string $referencia, string $observacion, string $centroOperativo)
    {
        $this->guia = $guia;
        $this->nombreDestinatario = $nombreDestinatario;
        $this->direccionDestinatario = $direccionDestinatario;
        $this->ciudadDestinatario = $ciudadDestinatario;
        $this->departamentoDestinatario = $departamentoDestinatario;
        $this->referencia = $referencia;
        $this->observacion = $observacion;
        $this->centroOperativo = $centroOperativo;
    }

    public function getGuia(): string
    {
        return $this->guia;
    }

    public function setGuia(string $guia): void
    {
        $this->guia = $guia;
    }

    public function getNombreDestinatario(): string
    {
        return $this->nombreDestinatario;
    }

    public function setNombreDestinatario(string $nombreDestinatario): void
    {
        $this->nombreDestinatario = $nombreDestinatario;
    }

    public function getDireccionDestinatario(): string
    {
        return $this->direccionDestinatario;
    }

    public function setDireccionDestinatario(string $direccionDestinatario): void
    {
        $this->direccionDestinatario = $direccionDestinatario;
    }

    public function getCiudadDestinatario(): string
    {
        return $this->ciudadDestinatario;
    }

    public function setCiudadDestinatario(string $ciudadDestinatario): void
    {
        $this->ciudadDestinatario = $ciudadDestinatario;
    }

    public function getReferencia(): string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia): void
    {
        $this->referencia = $referencia;
    }

    public function getObservacion(): string
    {
        return $this->observacion;
    }

    public function setObservacion(string $observacion): void
    {
        $this->observacion = $observacion;
    }

    public function getDepartamentoDestinatario(): string
    {
        return $this->departamentoDestinatario;
    }

    public function setDepartamentoDestinatario(string $departamentoDestinatario): void
    {
        $this->departamentoDestinatario = $departamentoDestinatario;
    }

    public function getCentroOperativo(): string
    {
        return $this->centroOperativo;
    }

    public function setCentroOperativo(string $centroOperativo): void
    {
        $this->centroOperativo = $centroOperativo;
    }
}