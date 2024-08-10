<?php

namespace App\DocumentManagement\Domain\Enums;

enum TypePortPayment : string implements EnumType
{
    use General;
    case Fv = '1';
    case Tp = '2';
    case Cp = '3';
    case Bo = '4';
    case No = '5';


    function getType(): string
    {
        return 'Tipo de PortePago';
    }
}
