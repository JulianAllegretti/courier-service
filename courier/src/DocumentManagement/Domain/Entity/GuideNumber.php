<?php

namespace App\DocumentManagement\Domain\Entity;

use App\DocumentManagement\Domain\Repository\GuideNumberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuideNumberRepository::class)]
#[ORM\Table('guide_number')]
class GuideNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_guide_number;

    #[ORM\Column(length: 255)]
    private string $initial_number;

    #[ORM\Column(length: 255)]
    private string $end_number;

    #[ORM\Column(length: 255)]
    private string $current_number;

    /**
     * @param int|null $id_guide_number
     * @param string $initial_number
     * @param string $end_number
     * @param string $current_number
     */
    public function __construct(?int $id_guide_number, string $initial_number, string $end_number, string $current_number)
    {
        $this->id_guide_number = $id_guide_number;
        $this->initial_number = $initial_number;
        $this->end_number = $end_number;
        $this->current_number = $current_number;
    }

    public function getIdGuideNumber(): ?int
    {
        return $this->id_guide_number;
    }

    public function getInitialNumber(): string
    {
        return $this->initial_number;
    }

    public function getEndNumber(): string
    {
        return $this->end_number;
    }

    public function getCurrentNumber(): string
    {
        return $this->current_number;
    }

    public function setCurrentNumber(string $current_number): void
    {
        $this->current_number = $current_number;
    }


}
