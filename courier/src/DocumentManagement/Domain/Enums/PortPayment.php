<?php

namespace App\DocumentManagement\Domain\Enums;

enum PortPayment : string implements EnumType
{
    use General;
    case Si = 'Si';
    case No = 'No';

    function getType(): string
    {
        return 'Porte pago';
    }
}
