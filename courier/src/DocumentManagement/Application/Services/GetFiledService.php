<?php

namespace App\DocumentManagement\Application\Services;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Repository\FiledRepository;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;

readonly class GetFiledService
{
    public function __construct(private FiledRepository $filedRepository)
    {
    }

    public function __invoke(FiledNumberValueObject $filedNumber): Filed|null
    {
        return $this->filedRepository->getFiled($filedNumber);
    }
}