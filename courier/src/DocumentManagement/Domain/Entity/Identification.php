<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\IdentificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentificationRepository::class)]
#[ORM\Table('identificacion')]
class Identification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_identificacion;

    #[ORM\Column(length: 255)]
    private ?string $documento;

    #[ORM\Column(length: 255)]
    private ?string $tipo_documento;

    /**
     * @param int|null $id_identificacion
     * @param string|null $documento
     * @param string|null $tipo_documento
     */
    public function __construct(?int $id_identificacion, ?string $documento, ?string $tipo_documento)
    {
        $this->id_identificacion = $id_identificacion;
        $this->documento = $documento;
        $this->tipo_documento = $tipo_documento;
    }


    public function getIdIdentificacion(): ?int
    {
        return $this->id_identificacion;
    }

    public function setIdIdentificacion(int $id_identificacion): static
    {
        $this->id_identificacion = $id_identificacion;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(string $documento): static
    {
        $this->documento = $documento;

        return $this;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(string $tipo_documento): static
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }
}
