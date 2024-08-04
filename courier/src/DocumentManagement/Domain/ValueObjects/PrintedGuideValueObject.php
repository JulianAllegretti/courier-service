<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class PrintedGuideValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'GuiaImpresa';
    private const MAX_LENGTH = 50;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}