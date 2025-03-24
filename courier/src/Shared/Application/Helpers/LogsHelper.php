<?php

namespace App\Shared\Application\Helpers;

use Doctrine\Common\Collections\ArrayCollection;

class LogsHelper
{
    public function mapLogResponse(array $logResponse, bool $documents = false): ArrayCollection
    {
        $collection = new ArrayCollection($logResponse);
        $logs = $collection->map(function ($value) use ($documents) {
            $array = [
                'id' => ($documents) ? $value->getIdLogGetDocument() : $value->getIdLogInsertInformation(),
                'numero_radicado' => $value->getNumeroRadicado(),
                'error_code' => '',
                'error_message' => '',
                'created_at' => $value->getCreatedAt()
            ];
            if ($documents) {
                $array['id_documento'] = $value->getIdDocumento();
            }

            if (!$value->getError()) {
                return $array;
            }
            $error = json_decode($value->getError());
            $array['error_code'] = $error->ErrorCode ?? '';
            $array['error_message'] = $error->ErrorMessage ?? '';

            return $array;
        });

        return $logs;
    }
}