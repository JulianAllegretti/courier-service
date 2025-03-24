<?php

namespace App\Shared\Application\Helpers;

use Doctrine\ORM\Tools\Pagination\Paginator;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSVHelper
{
    function downloadCSVFiled(Paginator $data): StreamedResponse {
        $allData = $data->getQuery()->setMaxResults(null)->getResult();
        return new StreamedResponse(function() use($allData) {
            $headers = ['numero_radicado', 'nombre_completo', 'celular', 'tipo_identificacion', 'identificacion', 'codigo_dane', 'codigo_guia', 'radicado_caso_padre', 'fecha_radicado', 'ruta_archivo'];
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, $headers,';');

            foreach($allData as $row) {
                $body = [
                    $row->getNumRadicado(),
                    $row->getNombreCompleto(),
                    $row->getCelular(),
                    $row->getFkIdentificacion() !== null ? $row->getIdentification()->getTipoDocumento() : '--',
                    $row->getFkIdentificacion() !== null ? $row->getIdentification()->getDocumento() : '--',
                    $row->getCodDane(),
                    $row->getCodigoGuia(),
                    $row->getRadicadoCasoPadre(),
                    $row->getCreatedAt()
                ];
                if ($row->getDocuments()->count() == 0) {
                    $body[] = '--';
                    fputcsv($handle, $body, ';');
                    continue;
                }

                foreach ($row->getDocuments() as $document) {
                    if ($document->getRuta() == '') {
                        continue;
                    }
                    $data = $body;
                    $data[] = $document->getRuta();
                    fputcsv($handle, $data, ';');
                }
            }

            fclose($handle);
        });
    }
}