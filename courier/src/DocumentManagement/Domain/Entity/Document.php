<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table('documento')]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_documento;

    #[ORM\Column]
    private int $fk_radicado;

    #[ORM\Column(length: 100)]
    private string $id_gestor_documento;

    #[ORM\Column(length: 255)]
    private string $end_point_file_net;

    #[ORM\Column]
    private int $orden_imp;

    #[ORM\Column]
    private int $num_paginas;

    #[ORM\Column()]
    private ?string $ruta;

    #[ORM\ManyToOne(targetEntity: Filed::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(name:"fk_radicado", referencedColumnName:"id_radicado")]
    private Filed $filed;

    /**
     * @param int|null $id_documento
     * @param int $fk_radicado
     * @param string $id_gestor_documento
     * @param string $end_point_file_net
     * @param int $orden_imp
     * @param int $num_paginas
     * @param string|null $ruta
     */
    public function __construct(?int $id_documento, int $fk_radicado, string $id_gestor_documento, string $end_point_file_net, int $orden_imp, int $num_paginas, ?string $ruta)
    {
        $this->id_documento = $id_documento;
        $this->fk_radicado = $fk_radicado;
        $this->id_gestor_documento = $id_gestor_documento;
        $this->end_point_file_net = $end_point_file_net;
        $this->orden_imp = $orden_imp;
        $this->num_paginas = $num_paginas;
        $this->ruta = $ruta;
    }

    public function getIdDocumento(): ?int
    {
        return $this->id_documento;
    }

    public function getFkRadicado(): int
    {
        return $this->fk_radicado;
    }

    public function getIdGestorDocumento(): string
    {
        return $this->id_gestor_documento;
    }

    public function getEndPointFileNet(): string
    {
        return $this->end_point_file_net;
    }

    public function getOrdenImp(): int
    {
        return $this->orden_imp;
    }

    public function getNumPaginas(): int
    {
        return $this->num_paginas;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(?string $ruta): void
    {
        $this->ruta = $ruta;
    }

    public function setFiled(Filed $filed): void
    {
        $this->filed = $filed;
    }
}
