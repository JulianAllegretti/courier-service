<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class SerieValueObject extends AdapterStringValueObject
{
    private const NAME = 'Serie';
    private const MAX_LENGTH = 250;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}