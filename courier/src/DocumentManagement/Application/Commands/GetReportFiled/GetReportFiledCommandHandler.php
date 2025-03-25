<?php

namespace App\DocumentManagement\Application\Commands\GetReportFiled;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Application\Helpers\ChartHelper;
use App\Shared\Domain\CommandHandler;

readonly class GetReportFiledCommandHandler implements CommandHandler
{
    public function __construct(private FiledRepository $repository, private ChartHelper $helper)
    {
    }

    public function __invoke(GetReportFiledCommand $command): void
    {
        $response = $this->repository->getReport($command->getStartDate(), $command->getEndDate());
        $command->setResponse($this->helper->getChartData($response, !is_null($command->getEndDate()), false));
    }
}