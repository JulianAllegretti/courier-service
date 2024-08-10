<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class SubjectValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'Asunto';
    private const MAX_LENGTH = 250;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}