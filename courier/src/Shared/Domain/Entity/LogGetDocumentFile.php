<?php

namespace App\Shared\Domain\Entity;
use App\Shared\Domain\Repository\LogGetDocumentFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogGetDocumentFileRepository::class)]
#[ORM\Table('log_get_document')]
class LogGetDocumentFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_log_get_document;

    #[ORM\Column(length: 50)]
    private string $numero_radicado;

    #[ORM\Column]
    private string $id_documento;

    #[ORM\Column]
    private string $request;

    #[ORM\Column]
    private string $error;

    /**
     * @param int|null $id_log_get_document
     * @param string $numero_radicado
     * @param string $id_documento
     * @param string $request
     * @param string $error
     */
    public function __construct(?int $id_log_get_document, string $numero_radicado, string $id_documento, string $request, string $error)
    {
        $this->id_log_get_document = $id_log_get_document;
        $this->numero_radicado = $numero_radicado;
        $this->id_documento = $id_documento;
        $this->request = $request;
        $this->error = $error;
    }

    public function getIdLogGetDocument(): ?int
    {
        return $this->id_log_get_document;
    }

    public function getNumeroRadicado(): string
    {
        return $this->numero_radicado;
    }

    public function getIdDocumento(): string
    {
        return $this->id_documento;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getError(): string
    {
        return $this->error;
    }


}