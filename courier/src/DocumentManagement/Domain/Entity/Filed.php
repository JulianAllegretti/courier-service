<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Comment\Doc;

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

    #[ORM\Column(length: 20)]
    private string $num_radicado;

    #[ORM\Column(length: 50)]
    private ?string $celular;

    #[ORM\Column(length: 50)]
    private ?string $num_tramite;

    #[ORM\Column(length: 5)]
    private string $cod_dane;

    #[ORM\Column(length: 100)]
    private string $direccion;

    #[ORM\Column(length: 50)]
    private string $guia_impresa;

    #[ORM\Column(length: 200)]
    private string $nombre_completo;

    #[ORM\Column(length: 50)]
    private ?string $telefono;

    #[ORM\Column(length: 50)]
    private string $prioridad;

    #[ORM\Column(length: 50)]
    private string $impreso;

    #[ORM\Column(length: 50)]
    private string $porte_pago;

    #[ORM\Column(length: 50)]
    private string $tipo_porte_pago;

    #[ORM\Column(length: 50)]
    private string $tipo_proceso;

    #[ORM\Column(length: 50)]
    private ?string $radicado_caso_padre;

    #[ORM\Column(length: 50)]
    private ?string $usuario_solicitante;

    #[ORM\Column(length: 50)]
    private string $codigo_guia;

    #[ORM\Column(length: 50)]
    private ?string $created_at;

    #[ORM\ManyToOne(targetEntity: Identification::class, inversedBy: 'filed')]
    #[ORM\JoinColumn(name:"fk_identificacion", referencedColumnName:"id_identificacion")]
    private Identification $identification;

    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'filed')]
    private Collection $documents;

    /**
     * @param int|null $id_radicado
     * @param int|null $fk_identificacion
     * @param string $num_radicado
     * @param string|null $celular
     * @param string|null $num_tramite
     * @param string $cod_dane
     * @param string $direccion
     * @param string $guia_impresa
     * @param string $nombre_completo
     * @param string|null $telefono
     * @param string $prioridad
     * @param string $impreso
     * @param string $porte_pago
     * @param string $tipo_porte_pago
     * @param string $tipo_proceso
     * @param string|null $radicado_caso_padre
     * @param string|null $usuario_solicitante
     * @param string $codigo_guia
     */
    public function __construct(?int $id_radicado, ?int $fk_identificacion, string $num_radicado, ?string $celular, ?string $num_tramite, string $cod_dane, string $direccion, string $guia_impresa, string $nombre_completo, ?string $telefono, string $prioridad, string $impreso, string $porte_pago, string $tipo_porte_pago, string $tipo_proceso, ?string $radicado_caso_padre, ?string $usuario_solicitante, string $codigo_guia)
    {
        $this->id_radicado = $id_radicado;
        $this->fk_identificacion = $fk_identificacion;
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
        $this->radicado_caso_padre = $radicado_caso_padre;
        $this->usuario_solicitante = $usuario_solicitante;
        $this->codigo_guia = $codigo_guia;
        $this->num_tramite = $num_tramite;
    }

    public function getIdRadicado(): ?int
    {
        return $this->id_radicado;
    }

    public function getFkIdentificacion(): ?int
    {
        return $this->fk_identificacion;
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

    public function getGuiaImpresa(): string
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

    public function getImpreso(): string
    {
        return $this->impreso;
    }

    public function getPortePago(): string
    {
        return $this->porte_pago;
    }

    public function getTipoPortePago(): string
    {
        return $this->tipo_porte_pago;
    }

    public function getTipoProceso(): string
    {
        return $this->tipo_proceso;
    }

    public function getRadicadoCasoPadre(): ?string
    {
        return $this->radicado_caso_padre;
    }

    public function getUsuarioSolicitante(): ?string
    {
        return $this->usuario_solicitante;
    }

    public function getCodigoGuia(): string
    {
        return $this->codigo_guia;
    }

    public function getNumTramite(): ?string
    {
        return $this->num_tramite;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getIdentification(): Identification
    {
        return $this->identification;
    }

    public function setIdentification(Identification $identification): void
    {
        $this->identification = $identification;
    }

}
