<?php

namespace App\Shared\Domain\Repository;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Entity\LogInsertInformation;

interface LogInsertInformationRepository
{
    function create(LogInsertInformation $log): LogInsertInformation;

    function getLogs(string $time_start, string $time_end, string $difference_days) : array;

    function getAllLogs(int $page) : ResponsePaginator;
}