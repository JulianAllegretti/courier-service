<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullValueObject;

class NumPagesValueObject extends AdapterNullValueObject
{
    private const NAME = 'NumPaginas';

    public function __construct($value)
    {
        parent::__construct($value, self::NAME);
    }

}