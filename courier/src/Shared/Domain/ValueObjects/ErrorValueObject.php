<?php

namespace App\Shared\Domain\ValueObjects;

class ErrorValueObject extends AdapterNullValueObject
{
    private const NAME = 'Error';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }
}