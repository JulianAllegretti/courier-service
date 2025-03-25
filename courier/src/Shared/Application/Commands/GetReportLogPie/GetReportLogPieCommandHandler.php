<?php

namespace App\Shared\Application\Commands\GetReportLogPie;

use App\Shared\Application\Helpers\ChartHelper;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogInsertInformationRepository;

readonly class GetReportLogPieCommandHandler implements CommandHandler
{
    public function __construct(private LogInsertInformationRepository $repository, private ChartHelper $helper)
    {
    }

    public function __invoke(GetReportLogPieCommand $command): void
    {
        $response = $this->repository->getReportPie($command->getStartDate(), $command->getEndDate());
        $command->setResponse($this->helper->getChartDataPie($response));
    }

}