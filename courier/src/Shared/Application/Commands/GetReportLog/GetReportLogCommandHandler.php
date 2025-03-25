<?php

namespace App\Shared\Application\Commands\GetReportLog;

use App\Shared\Application\Helpers\ChartHelper;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Repository\LogInsertInformationRepository;

readonly class GetReportLogCommandHandler implements CommandHandler
{
    public function __construct(private LogInsertInformationRepository $repository, private ChartHelper $helper)
    {
    }

    public function __invoke(GetReportLogCommand $command): void
    {
        $response = $this->repository->getReport($command->getStartDate(), $command->getEndDate());
        $command->setResponse($this->helper->getChartData($response, !is_null($command->getEndDate()), true));
    }
}