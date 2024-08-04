<?php

namespace App\DocumentManagement\Domain\Enums;

enum ProcessType : string implements EnumType
{
    use General;
    case RPM = 'RPM';
    case BEPS = 'BEPS';
    case RPMCOBRO = 'RPMCOBRO';

    function getType(): string
    {
        return 'Tipo de proceso';
    }
}