<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class EndPointFileNetValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'EndPointFileNet';
    private const MAX_LENGTH = 250;


    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }
}