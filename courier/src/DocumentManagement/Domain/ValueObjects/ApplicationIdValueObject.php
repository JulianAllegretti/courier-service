<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class ApplicationIdValueObject extends AdapterStringValueObject
{
    private const NAME = 'ApplicationID';
    private const MAX_LENGTH = 250;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}