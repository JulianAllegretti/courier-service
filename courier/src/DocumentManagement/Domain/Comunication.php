<?php

namespace App\DocumentManagement\Domain;

class Comunication
{
    /**
     * @var string
     */
    public $Celular;
    /**
     * @var string
     */
    public $CodDane;
    /**
     * @var string
     */
    public $Direccion;

    /**
     * @var array
     */
    public $Documentos;
    /**
     * @var string
     */
    public $GuiaImpresa;
    /**
     * @var mixed
     */
    public $IdentificacionVo;
    /**
     * @var string
     */
    public $Impreso;
    /**
     * @var string
     */
    public $NombreCompleto;
    /**
     * @var string
     */
    public $NumRadicado;
    /**
     * @var string
     */
    public $NumTramite;
    /**
     * @var string
     */
    public $PortePago;
    /**
     * @var string
     */
    public $Prioridad;
    /**
     * @var string
     */
    public $Telefono;
    /**
     * @var string
     */
    public $TipoPortePago;

    /**
     * @var string
     */
    public $TipoProceso;
    /**
     * @var string
     */
    public $RadicadoCasoPadre;
    /**
     * @var string
     */
    public $UsuarioSolicitante;

    /**
     * @param string $Celular
     * @param string $CodeDane
     * @param string $Direccion
     * @param array $Documentos
     * @param string $GuiaImpresa
     * @param mixed $IdentificacionVo
     * @param string $Impreso
     * @param string $NombreCompleto
     * @param string $NumRadicado
     * @param string $NumTramite
     * @param string $PortePago
     * @param string $Prioridad
     * @param string $Telefono
     * @param string $TipoPortePago
     * @param string $TipoProceso
     * @param string $RadicadoCasoPadre
     * @param string $UsuarioSolicitante
     */
    public function __construct(string $Celular, string $CodeDane, string $Direccion, array $Documentos, string $GuiaImpresa, mixed $IdentificacionVo, string $Impreso, string $NombreCompleto, string $NumRadicado, string $NumTramite, string $PortePago, string $Prioridad, string $Telefono, string $TipoPortePago, string $TipoProceso, string $RadicadoCasoPadre, string $UsuarioSolicitante)
    {
        $this->Celular = $Celular;
        $this->CodDane = $CodeDane;
        $this->Direccion = $Direccion;
        $this->Documentos = $Documentos;
        $this->GuiaImpresa = $GuiaImpresa;
        $this->IdentificacionVo = $IdentificacionVo;
        $this->Impreso = $Impreso;
        $this->NombreCompleto = $NombreCompleto;
        $this->NumRadicado = $NumRadicado;
        $this->NumTramite = $NumTramite;
        $this->PortePago = $PortePago;
        $this->Prioridad = $Prioridad;
        $this->Telefono = $Telefono;
        $this->TipoPortePago = $TipoPortePago;
        $this->TipoProceso = $TipoProceso;
        $this->RadicadoCasoPadre = $RadicadoCasoPadre;
        $this->UsuarioSolicitante = $UsuarioSolicitante;
    }


}