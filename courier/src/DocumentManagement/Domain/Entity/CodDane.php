<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table('cod_dane')]
class CodDane
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    private string $depto;

    #[ORM\Column(length: 180)]
    private string $provincia;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 50)]
    private string $courier;

    /**
     * @param int|null $id
     * @param string $depto
     * @param string $provincia
     * @param string $code
     * @param string $name
     * @param string $courier
     */
    public function __construct(?int $id, string $depto, string $provincia, string $code, string $name, string $courier)
    {
        $this->id = $id;
        $this->depto = $depto;
        $this->provincia = $provincia;
        $this->code = $code;
        $this->name = $name;
        $this->courier = $courier;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDepto(): string
    {
        return $this->depto;
    }

    public function setDepto(string $depto): void
    {
        $this->depto = $depto;
    }

    public function getProvincia(): string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): void
    {
        $this->provincia = $provincia;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCourier(): string
    {
        return $this->courier;
    }

    public function setCourier(string $courier): void
    {
        $this->courier = $courier;
    }
}
