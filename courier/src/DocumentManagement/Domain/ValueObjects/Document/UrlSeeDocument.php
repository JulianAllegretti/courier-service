<?php

namespace App\DocumentManagement\Domain\ValueObjects\Document;

use App\Shared\Domain\ValueObjects\AdapterNullStringValueObject;

class UrlSeeDocument extends AdapterNullStringValueObject
{
    private const NAME = 'UrlVerDocumento';
    private const MAX_LENGTH = 250;


    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }
}