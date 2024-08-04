<?php

namespace App\DocumentManagement\Domain\Repository;


use App\DocumentManagement\Domain\Entity\GuideNumber;

interface GuideNumberRepository
{
    function updateCurrentNumber(): string;

    function getGuideNumber(): GuideNumber;
}