<?php

namespace App\DocumentManagement\Application\Commands\CreateInformation;

use App\DocumentManagement\Domain\Document;
use App\DocumentManagement\Domain\Enums\PortPayment;
use App\DocumentManagement\Domain\Enums\Printed;
use App\DocumentManagement\Domain\Enums\Priority;
use App\DocumentManagement\Domain\Enums\ProcessType;
use App\DocumentManagement\Domain\Enums\TypePortPayment;
use App\DocumentManagement\Domain\Identification;
use App\Shared\Domain\Command;

class CreateInformationCommand implements Command
{
    private string $guideNumber;

    public function __construct(
        private string          $filedNumber,
        private string          $codDane,
        private string          $address,
        private string          $printedGuide,
        private array           $documents,
        private string          $fullName,
        private Priority        $priority,
        private Printed         $printed,
        private TypePortPayment $typePortPayment,
        private ProcessType     $processType,
        private PortPayment     $portPayment,
        private ?string         $phone = '',
        private ?string         $filedCaseFather = '',
        private ?Identification $identification = null,
        private ?string         $cellphone = '',
        private ?string         $applicant = '',
        private ?string         $processNumber = ''
    )
    {
    }

    public function getFiledNumber(): string
    {
        return $this->filedNumber;
    }

    public function getCellphone(): string
    {
        return $this->cellphone;
    }

    public function getCodDane(): string
    {
        return $this->codDane;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPrintedGuide(): string
    {
        return $this->printedGuide;
    }

    /**
     * @return Document[]
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    public function getIdentification(): ?Identification
    {
        return $this->identification;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getPrinted(): Printed
    {
        return $this->printed;
    }

    public function getTypePortPayment(): TypePortPayment
    {
        return $this->typePortPayment;
    }

    public function getProcessType(): ProcessType
    {
        return $this->processType;
    }

    public function getFiledCaseFather(): ?string
    {
        return $this->filedCaseFather;
    }

    public function getApplicant(): ?string
    {
        return $this->applicant;
    }

    public function getPortPayment(): PortPayment
    {
        return $this->portPayment;
    }

    public function setGuideNumber(string $guideNumber): void
    {
        $this->guideNumber = $guideNumber;
    }

    public function getGuideNumber(): string
    {
        return $this->guideNumber;
    }

    public function getProcessNumber(): ?string
    {
        return $this->processNumber;
    }

}