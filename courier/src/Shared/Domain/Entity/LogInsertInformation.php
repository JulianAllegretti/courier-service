<?php

namespace App\Shared\Domain\Entity;
use App\Shared\Domain\Log;
use App\Shared\Domain\Repository\LogInsertInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogInsertInformationRepository::class)]
#[ORM\Table('log_insert_information')]
class LogInsertInformation implements Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_log_insert_information;

    #[ORM\Column(length: 50)]
    private string $numero_radicado;

    #[ORM\Column]
    private string $request;

    #[ORM\Column]
    private string $error;

    #[ORM\Column(length: 50)]
    private ?string $created_at;

    /**
     * @param int|null $id_log_insert_information
     * @param string $numero_radicado
     * @param string $request
     * @param string $error
     */
    public function __construct(?int $id_log_insert_information, string $numero_radicado, string $request, string $error)
    {
        $this->id_log_insert_information = $id_log_insert_information;
        $this->numero_radicado = $numero_radicado;
        $this->request = $request;
        $this->error = $error;
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function getIdLogInsertInformation(): ?int
    {
        return $this->id_log_insert_information;
    }

    public function getNumeroRadicado(): string
    {
        return $this->numero_radicado;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    function getDecodedRequest(): mixed
    {
        return json_decode(trim($this->request));
    }

    function getDecodedError(): mixed
    {
        return json_decode(trim($this->error));
    }
}