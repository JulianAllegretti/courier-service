<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class AddressValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'Dirección';
    private const MAX_LENGTH =  100;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}