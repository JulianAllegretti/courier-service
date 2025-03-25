<?php

namespace App\Shared\Application\Commands\GetReportLogPie;

use App\Shared\Domain\Command;
use DateTime;

class GetReportLogPieCommand implements Command
{
    /**
     * @var DateTime
     */
    private DateTime $startDate;

    /**
     * @var DateTime|null
     */
    private DateTime|null $endDate;

    /**
     * @var array
     */
    private array $response;

    /**
     * @param DateTime $startDate
     * @param DateTime|null $endDate
     */
    public function __construct(DateTime $startDate, ?DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function setResponse(array $response): void
    {
        $this->response = $response;
    }
}