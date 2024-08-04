<?php

namespace App\DocumentManagement\Domain\ValueObjects\Identification;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class DocumentNumberValueObject extends AdapterStringValueObject
{
    private const NAME = 'Documento';
    private const MAX_LENGTH = 50;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}