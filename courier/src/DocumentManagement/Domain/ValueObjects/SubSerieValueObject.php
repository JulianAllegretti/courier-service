<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class SubSerieValueObject extends AdapterStringValueObject
{
    private const NAME = 'Subserie';
    private const MAX_LENGTH = 250;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}