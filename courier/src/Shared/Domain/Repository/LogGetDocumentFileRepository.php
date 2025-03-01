<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\LogGetDocumentFile;

interface LogGetDocumentFileRepository
{
    function create(LogGetDocumentFile $log): LogGetDocumentFile;

    function getLogs(string $time_start, string $time_end, string $difference_days) : array;

    function getAllLogs() : array;
}