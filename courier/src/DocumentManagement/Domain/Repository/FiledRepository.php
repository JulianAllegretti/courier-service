<?php

namespace App\DocumentManagement\Domain\Repository;

use App\DocumentManagement\Domain\Entity\Filed;
use App\DocumentManagement\Domain\Entity\Identification;
use App\DocumentManagement\Domain\ResponsePaginator;
use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;

interface FiledRepository
{
    function create(Filed $filed, Identification $identification): Filed;

    function getFiled(FiledNumberValueObject $filedNumberValueObject): Filed|null;

    function getDocuments(string $time_start, string $time_end, string $difference_days) : array;

    function getAllFiled(int $page, array $params) : ResponsePaginator;

    function getFiledById(int $id_filed) : Filed|null;

    function getReportByHourAndDate(): array;

    function getReport(\DateTime $dateStart, \DateTime|null $dateEnd): array;
}