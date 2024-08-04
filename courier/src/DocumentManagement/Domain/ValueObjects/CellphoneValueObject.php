<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class CellphoneValueObject extends AdapterStringValueObject
{
    private const NAME = 'Celular';
    private const MAX_LENGTH = 50;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}