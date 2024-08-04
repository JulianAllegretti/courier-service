<?php

namespace App\DocumentManagement\Domain\ValueObjects;


use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class FullNameValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'NombreCompleto';
    private const MAX_LENGTH = 200;


    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }
}