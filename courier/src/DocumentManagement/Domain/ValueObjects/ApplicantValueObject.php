<?php

namespace App\DocumentManagement\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\AdapterStringValueObject;

class ApplicantValueObject extends AdapterStringValueObject
{
    private const NAME = 'UsuarioSolicitante';
    private const MAX_LENGTH = 200;

    public function __construct($value)
    {
        parent::__construct($value, self::NAME, self::MAX_LENGTH);
    }


}