<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class CodDaneValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'CodDane';
    private const MAX_LENGTH = 5;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }
}