<?php

namespace App\Shared\Domain\Entity;
use App\Shared\Domain\Repository\LogInsertInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogInsertInformationRepository::class)]
#[ORM\Table('log_insert_information')]
class LogInsertInformation
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


}