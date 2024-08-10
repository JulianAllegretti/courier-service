<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class SubProcessValueObject extends AdapterStringValueObject
{
    private const NAME = 'Subtramite';
    private const MAX_LENGTH = 200;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}