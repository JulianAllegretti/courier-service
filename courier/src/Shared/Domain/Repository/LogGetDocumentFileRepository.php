<?php

namespace App\Shared\Domain\Repository;

use App\DocumentManagement\Domain\ResponsePaginator;
use App\Shared\Domain\Entity\LogGetDocumentFile;
use App\Shared\Domain\Log;

interface LogGetDocumentFileRepository
{
    function create(LogGetDocumentFile $log): LogGetDocumentFile;

    function getLogs(string $time_start, string $time_end, string $difference_days) : array;

    function getAllLogs(int $page, array $params) : ResponsePaginator;

    function getLogsByNumFiled(string $num_filed) : array;

    function getLogsByDocumentId(string $document_id) : array;

    function getLogById(int $log_id): Log|null;
}