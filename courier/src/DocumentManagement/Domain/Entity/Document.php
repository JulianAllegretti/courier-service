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

    #[ORM\Column(length: 100)]
    private string $id_gestor_documento;

    #[ORM\Column(length: 255)]
    private string $url_ver_documento;

    #[ORM\Column()]
    private ?string $ruta;

    /**
     * @param int|null $id_documento
     * @param string $id_gestor_documento
     * @param string $url_ver_documento
     * @param string|null $ruta
     */
    public function __construct(?int $id_documento, string $id_gestor_documento, string $url_ver_documento, ?string $ruta)
    {
        $this->id_documento = $id_documento;
        $this->id_gestor_documento = $id_gestor_documento;
        $this->url_ver_documento = $url_ver_documento;
        $this->ruta = $ruta;
    }

    public function getIdDocumento(): ?int
    {
        return $this->id_documento;
    }

    public function getIdGestorDocumento(): string
    {
        return $this->id_gestor_documento;
    }

    public function getUrlVerDocumento(): string
    {
        return $this->url_ver_documento;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }
}
