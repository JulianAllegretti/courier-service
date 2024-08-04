<?php

namespace App\DocumentManagement\Domain\Enums;

enum TypePortPayment : string implements EnumType
{
    use General;
    case Fv = 'Fv';
    case Tp = 'Tp';
    case Cp = 'Cp';
    case Bo = 'Bo';
    case No = 'No';


    function getType(): string
    {
        return 'Tipo de PortePago';
    }
}
