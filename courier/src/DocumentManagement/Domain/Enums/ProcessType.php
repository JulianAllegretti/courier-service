<?php

namespace App\DocumentManagement\Domain\Enums;

enum ProcessType : string implements EnumType
{
    use General;
    case RPM = '1';
    case BEPS = '2';
    case RPMCOBRO = '3';

    function getType(): string
    {
        return 'Tipo de proceso';
    }
}