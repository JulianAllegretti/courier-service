<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Identification;

interface IdentificationRepository
{
    function createIfNoExist(Identification $identification): Identification;
}