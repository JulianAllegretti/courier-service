<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class GuideNumberValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'CodGuia';
    private const MAX_LENGTH =  50;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}