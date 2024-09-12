<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Filed;

interface FiledRepository
{
    function create(Filed $filed): Filed;
    function getDocuments(string $time_start, string $time_end, string $difference_days) : array;
}