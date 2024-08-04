<?php

namespace App\DocumentManagement\Domain\Enums;

enum DocumentType: string implements EnumType
{
    use General;
    case NU = 'NU';
    case CC = 'CC';
    case NI = 'NI';
    case TI = 'TI';
    case CE = 'CE';
    case PA = 'PA';
    case RC = 'RC';
    case CD = 'CD';
    case AS = 'AS';
    case MS = 'MS';
    case F = 'F';
    case PE = 'PE';

    function getType(): string
    {
        return 'Tipo de Documento';
    }
}