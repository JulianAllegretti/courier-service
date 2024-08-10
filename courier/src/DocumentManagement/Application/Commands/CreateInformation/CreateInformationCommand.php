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
        private Document        $document,
        private string          $fullName,
        private Priority        $priority,
        private Printed         $printed,
        private TypePortPayment $typePortPayment,
        private ProcessType     $processType,
        private PortPayment     $portPayment,
        private ?string         $phone = '',
        private ?string         $process = '',
        private ?Identification $identification = null,
        private ?string         $cellphone = '',
        private ?string         $subProcess = '',
        private ?string         $subject = '',
        private ?int            $shippingType = -1,
        private ?string         $serie = '',
        private ?string         $subSerie = '',
        private ?string         $inputSystem = '',
        private ?string         $applicationID = '',
        private ?string         $transactionID = '',
        private ?string         $idCase = '',
        private ?string         $eventTriggered = '',
        private ?string         $processName = '',
        private ?string         $trace = ''
    )
    {
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getShippingType(): ?int
    {
        return $this->shippingType;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function getSubSerie(): ?string
    {
        return $this->subSerie;
    }

    public function getInputSystem(): ?string
    {
        return $this->inputSystem;
    }

    public function getApplicationID(): ?string
    {
        return $this->applicationID;
    }

    public function getTransactionID(): ?string
    {
        return $this->transactionID;
    }

    public function getIdCase(): ?string
    {
        return $this->idCase;
    }

    public function getEventTriggered(): ?string
    {
        return $this->eventTriggered;
    }

    public function getProcessName(): ?string
    {
        return $this->processName;
    }

    public function getTrace(): ?string
    {
        return $this->trace;
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
     * @return Document
     */
    public function getDocuments(): Document
    {
        return $this->document;
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

    public function getProcess(): ?string
    {
        return $this->process;
    }

    public function getSubProcess(): ?string
    {
        return $this->subProcess;
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

}