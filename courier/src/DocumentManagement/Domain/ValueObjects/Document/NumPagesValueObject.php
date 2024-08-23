<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullIntValueObject;

class NumPagesValueObject extends AdapterNullIntValueObject
{
    private const NAME = 'NumPaginas';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }

}