<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullIntValueObject;

class OrderImpValueObject extends AdapterNullIntValueObject
{
    private const NAME = 'OrdenImp';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }

}