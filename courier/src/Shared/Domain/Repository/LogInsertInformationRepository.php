<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\LogInsertInformation;

interface LogInsertInformationRepository
{
    function create(LogInsertInformation $log): LogInsertInformation;
}