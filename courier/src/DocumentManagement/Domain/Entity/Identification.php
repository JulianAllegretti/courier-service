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
    private ?string $numero_documento;

    #[ORM\Column(length: 255)]
    private ?string $tipo_documento;

    /**
     * @param int|null $id_identificacion
     * @param string|null $numero_documento
     * @param string|null $tipo_documento
     */
    public function __construct(?int $id_identificacion, ?string $numero_documento, ?string $tipo_documento)
    {
        $this->id_identificacion = $id_identificacion;
        $this->numero_documento = $numero_documento;
        $this->tipo_documento = $tipo_documento;
    }

    public function getIdIdentificacion(): ?int
    {
        return $this->id_identificacion;
    }

    public function getNumeroDocumento(): ?string
    {
        return $this->numero_documento;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }


}
