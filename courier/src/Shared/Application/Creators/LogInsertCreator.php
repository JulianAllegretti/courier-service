<?php

namespace App\Shared\Application\Creators;

use App\DocumentManagement\Domain\ValueObjects\FiledNumberValueObject;
use App\Shared\Domain\Entity\LogInsertInformation;
use App\Shared\Domain\ValueObjects\ErrorValueObject;
use App\Shared\Domain\ValueObjects\RequestValueObject;
use App\Shared\Domain\Repository\LogInsertInformationRepository;

class LogInsertCreator
{

    public function __construct(private LogInsertInformationRepository $repository)
    {}

    public function __invoke(FiledNumberValueObject $filedNumber, RequestValueObject $request, ErrorValueObject $error): void
    {
        $log = new LogInsertInformation(null, $filedNumber->getValue(), $request->getValue(), $error->getValue());
        $this->repository->create($log);
    }

}