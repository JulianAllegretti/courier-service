<?php

namespace App\DocumentManagement\Application\Mapper;

class SaveInformationRestMapper
{
    public static function map(\stdClass $data): \stdClass
    {
        $mapped = new \stdClass();

        $mapped->NumRadicado        = $data->numeroRadicado ?? '';
        $mapped->CodDane            = $data->CodigoDane ?? '';
        $mapped->Direccion          = $data->Direccion ?? '';
        $mapped->NombreCompleto     = $data->NombreCompleto ?? '';
        $mapped->Prioridad          = self::mapPrioridad($data->Prioridad ?? null);
        $mapped->Impreso            = self::mapBool($data->Impreso ?? false);
        $mapped->TipoPortePago      = !empty($data->TipoPortePago) ? $data->TipoPortePago : 'No';
        $mapped->TipoProceso        = $data->TipoProceso ?? '';
        $mapped->PortePago          = self::mapBool($data->PortePago ?? false);
        $mapped->Telefono           = $data->Telefono ?? '';
        $mapped->Celular            = $data->Celular ?? '';
        $mapped->GuiaImpresa        = $data->GuiaImpresa ?? '';
        $mapped->RadicadoCasoPadre  = $data->Radicado ?? '';
        $mapped->UsuarioSolicitante = $data->UsuarioSolicitante ?? '';
        $mapped->NumTramite         = (string)($data->NumTramite ?? '');
        $mapped->EventName          = $data->eventName ?? null;
        $mapped->IdCase             = $data->idCase ?? null;

        $mapped->IdentificacionVo = null;
        if (!empty($data->NumeroDocumento) && !empty($data->TipoDocumento)) {
            $identificacion = new \stdClass();
            $identificacion->Documento    = $data->NumeroDocumento;
            $identificacion->TipoDocumento = $data->TipoDocumento;
            $mapped->IdentificacionVo = $identificacion;
        }

        $endPoint = $data->EndPointeNet ?? '';
        $mapped->Documentos = [];
        foreach (($data->Documentos ?? []) as $doc) {
            $docObj = new \stdClass();
            $docObj->IdDocumento     = $doc->guid ?? '';
            $docObj->EndPointFilenet = $endPoint;
            $docObj->OrdenImp        = 1;
            $docObj->NumPaginas      = 1;
            $docObj->NombreArchivo   = $doc->nombreArchivo ?? null;
            $mapped->Documentos[] = $docObj;
        }

        return $mapped;
    }

    private static function mapBool(mixed $value): string
    {
        return ($value === true || strtolower((string)$value) === 'si') ? 'Si' : 'No';
    }

    // Prioridad viene como entero (1 = Ur urgente, 0 = No normal) o como string directo
    private static function mapPrioridad(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'Ur' : 'No';
        }
        if (is_int($value)) {
            return $value === 1 ? 'Ur' : 'No';
        }
        return (string)($value ?? 'No');
    }
}