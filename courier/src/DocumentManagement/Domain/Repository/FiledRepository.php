<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Filed;

interface FiledRepository
{
    function create(Filed $filed): Filed;
}