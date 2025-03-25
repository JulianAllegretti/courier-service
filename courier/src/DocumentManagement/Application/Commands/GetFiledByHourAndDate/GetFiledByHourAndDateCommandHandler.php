<?php

namespace App\DocumentManagement\Application\Commands\GetFiledByHourAndDate;

use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\Shared\Domain\CommandHandler;

readonly class GetFiledByHourAndDateCommandHandler implements CommandHandler
{

    public function __construct(private FiledRepository $repository)
    {
    }

    public function __invoke(GetFiledByHourAndDateCommand $command): void
    {
        $queryResult = $this->repository->getReportByHourAndDate();
        $result = array();
        foreach ($queryResult as $element) {
            $result[$element['diaSemana']][$element['hora']] = $element['totalRadicados'];
        }
        $command->setResult($result);
    }
}