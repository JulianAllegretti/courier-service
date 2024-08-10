<?php

namespace App\DocumentManagement\Domain\Enums;

enum Printed : string implements EnumType
{
    use General;

    case Si = '1';
    case No = '0';

    function getType(): string
    {
        return 'Impreso';
    }
}
