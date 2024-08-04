<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class FiledNumberValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'Número de Radicado';
    private const MAX_LENGTH = 20;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}