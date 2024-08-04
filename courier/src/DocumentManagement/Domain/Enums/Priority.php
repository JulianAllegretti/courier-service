<?php

namespace App\DocumentManagement\Domain\Enums;

enum Priority: string implements EnumType
{
    use General;
    case Ur = 'Ur';
    case No = 'No';

    function getType(): string
    {
        return 'Prioridad';
    }
}
