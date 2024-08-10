<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class TraceValueObject extends AdapterStringValueObject
{
    private const NAME = 'Trace';
    private const MAX_LENGTH = 20;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}