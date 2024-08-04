<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class DocumentIdValueObject extends AdapterNullStringValueObject
{
    private const NAME = 'IdDocumento';
    private const MAX_LENGTH = 100;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }

}