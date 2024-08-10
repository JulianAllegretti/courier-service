<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterNullValueObject;

class ShippingTypeValueObject extends AdapterNullValueObject
{
    private const NAME = 'TipoEnvio';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }


}