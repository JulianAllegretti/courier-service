<?php

namespace App\Shared\Domain\ValueObjects;

class RequestValueObject extends AdapterNullValueObject
{
    private const NAME = 'Request';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }
}