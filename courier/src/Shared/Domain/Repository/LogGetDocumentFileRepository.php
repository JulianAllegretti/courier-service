<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\LogGetDocumentFile;

interface LogGetDocumentFileRepository
{
    function create(LogGetDocumentFile $log): LogGetDocumentFile;
}