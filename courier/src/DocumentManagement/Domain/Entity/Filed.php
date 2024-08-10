<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiledRepository::class)]
#[ORM\Table('radicado')]
class Filed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_radicado;

    #[ORM\Column]
    private ?int $fk_identificacion;

    private ?int $fk_documento;

    #[ORM\Column(length: 20)]
    private string $num_radicado;

    #[ORM\Column(length: 50)]
    private ?string $celular;

    #[ORM\Column(length: 5)]
    private string $cod_dane;

    #[ORM\Column(length: 100)]
    private string $direccion;

    #[ORM\Column(length: 50)]
    private ?string $guia_impresa;

    #[ORM\Column(length: 200)]
    private string $nombre_completo;

    #[ORM\Column(length: 50)]
    private ?string $telefono;

    #[ORM\Column(length: 50)]
    private string $prioridad;

    #[ORM\Column()]
    private bool $impreso;

    #[ORM\Column()]
    private bool $porte_pago;

    #[ORM\Column()]
    private int $tipo_porte_pago;

    #[ORM\Column()]
    private int $tipo_proceso;

    #[ORM\Column(length: 100)]
    private ?string $tramite;

    #[ORM\Column(length: 200)]
    private ?string $subtramite;

    #[ORM\Column(length: 250)]
    private ?string $asunto;
    #[ORM\Column()]
    private ?int $tipo_envio;
    #[ORM\Column(length: 250)]
    private ?string $serie;
    #[ORM\Column(length: 250)]
    private ?string $subserie;
    #[ORM\Column(length: 250)]
    private ?string $input_system;
    #[ORM\Column(length: 250)]
    private ?string $application_id;
    #[ORM\Column(length: 250)]
    private ?string $transaction_id;
    #[ORM\Column(length: 250)]
    private ?string $id_case;
    #[ORM\Column(length: 250)]
    private ?string $evento_invocado;
    #[ORM\Column(length: 250)]
    private ?string $nombre_proceso;
    #[ORM\Column(length: 20)]
    private ?string $trace;
    #[ORM\Column(length: 50)]
    private string $codigo_guia;

    /**
     * @param int|null $id_radicado
     * @param int|null $fk_identificacion
     * @param int|null $fk_documento
     * @param string $num_radicado
     * @param string|null $celular
     * @param string $cod_dane
     * @param string $direccion
     * @param string|null $guia_impresa
     * @param string $nombre_completo
     * @param string|null $telefono
     * @param string $prioridad
     * @param bool $impreso
     * @param bool $porte_pago
     * @param int $tipo_porte_pago
     * @param int $tipo_proceso
     * @param string|null $tramite
     * @param string|null $subtramite
     * @param string|null $asunto
     * @param int|null $tipo_envio
     * @param string|null $serie
     * @param string|null $subserie
     * @param string|null $input_system
     * @param string|null $application_id
     * @param string|null $transaction_id
     * @param string|null $id_case
     * @param string|null $evento_invocado
     * @param string|null $nombre_proceso
     * @param string|null $trace
     * @param string $codigo_guia
     */
    public function __construct(?int $id_radicado, ?int $fk_identificacion, ?int $fk_documento, string $num_radicado, ?string $celular, string $cod_dane, string $direccion, ?string $guia_impresa, string $nombre_completo, ?string $telefono, string $prioridad, bool $impreso, bool $porte_pago, int $tipo_porte_pago, int $tipo_proceso, ?string $tramite, ?string $subtramite, ?string $asunto, ?int $tipo_envio, ?string $serie, ?string $subserie, ?string $input_system, ?string $application_id, ?string $transaction_id, ?string $id_case, ?string $evento_invocado, ?string $nombre_proceso, ?string $trace, string $codigo_guia)
    {
        $this->id_radicado = $id_radicado;
        $this->fk_identificacion = $fk_identificacion;
        $this->fk_documento = $fk_documento;
        $this->num_radicado = $num_radicado;
        $this->celular = $celular;
        $this->cod_dane = $cod_dane;
        $this->direccion = $direccion;
        $this->guia_impresa = $guia_impresa;
        $this->nombre_completo = $nombre_completo;
        $this->telefono = $telefono;
        $this->prioridad = $prioridad;
        $this->impreso = $impreso;
        $this->porte_pago = $porte_pago;
        $this->tipo_porte_pago = $tipo_porte_pago;
        $this->tipo_proceso = $tipo_proceso;
        $this->tramite = $tramite;
        $this->subtramite = $subtramite;
        $this->asunto = $asunto;
        $this->tipo_envio = $tipo_envio;
        $this->serie = $serie;
        $this->subserie = $subserie;
        $this->input_system = $input_system;
        $this->application_id = $application_id;
        $this->transaction_id = $transaction_id;
        $this->id_case = $id_case;
        $this->evento_invocado = $evento_invocado;
        $this->nombre_proceso = $nombre_proceso;
        $this->trace = $trace;
        $this->codigo_guia = $codigo_guia;
    }

    public function getIdRadicado(): ?int
    {
        return $this->id_radicado;
    }

    public function getFkIdentificacion(): ?int
    {
        return $this->fk_identificacion;
    }

    public function getFkDocumento(): ?int
    {
        return $this->fk_documento;
    }

    public function getNumRadicado(): string
    {
        return $this->num_radicado;
    }

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function getCodDane(): string
    {
        return $this->cod_dane;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function getGuiaImpresa(): ?string
    {
        return $this->guia_impresa;
    }

    public function getNombreCompleto(): string
    {
        return $this->nombre_completo;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function getPrioridad(): string
    {
        return $this->prioridad;
    }

    public function isImpreso(): bool
    {
        return $this->impreso;
    }

    public function isPortePago(): bool
    {
        return $this->porte_pago;
    }

    public function getTipoPortePago(): int
    {
        return $this->tipo_porte_pago;
    }

    public function getTipoProceso(): int
    {
        return $this->tipo_proceso;
    }

    public function getTramite(): ?string
    {
        return $this->tramite;
    }

    public function getSubtramite(): ?string
    {
        return $this->subtramite;
    }

    public function getAsunto(): ?string
    {
        return $this->asunto;
    }

    public function getTipoEnvio(): ?int
    {
        return $this->tipo_envio;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function getSubserie(): ?string
    {
        return $this->subserie;
    }

    public function getInputSystem(): ?string
    {
        return $this->input_system;
    }

    public function getApplicationId(): ?string
    {
        return $this->application_id;
    }

    public function getTransactionId(): ?string
    {
        return $this->transaction_id;
    }

    public function getIdCase(): ?string
    {
        return $this->id_case;
    }

    public function getEventoInvocado(): ?string
    {
        return $this->evento_invocado;
    }

    public function getNombreProceso(): ?string
    {
        return $this->nombre_proceso;
    }

    public function getTrace(): ?string
    {
        return $this->trace;
    }

    public function getCodigoGuia(): string
    {
        return $this->codigo_guia;
    }
}
