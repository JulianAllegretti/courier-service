<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class ProcessValueObject extends AdapterStringValueObject
{
    private const NAME = 'Tramite';
    private const MAX_LENGTH = 20;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }
}