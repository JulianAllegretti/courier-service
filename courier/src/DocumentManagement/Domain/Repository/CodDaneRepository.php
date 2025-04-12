<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\CodDane;

interface CodDaneRepository
{
    function getCodDane(string $code): CodDane | null;
}