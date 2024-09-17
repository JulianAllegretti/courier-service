<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Entity\Identification;

interface FiledRepository
{
    function create(Filed $filed, Identification $identification): Filed;
    function getDocuments(string $time_start, string $time_end, string $difference_days) : array;
}