<?php

namespace App\Shared\Application\Helpers;

use Doctrine\Common\Collections\ArrayCollection;

class LogsHelper
{
    public function mapLogResponse(array $logResponse): ArrayCollection
    {
        $collection = new ArrayCollection($logResponse);
        $logs = $collection->map(function (array $value){
            if (!$value['error']) {
                return $value;
            }
            $error = json_decode($value['error']);
            $value['error_code'] = $error->ErrorCode ?? '';
            $value['error_message'] = $error->ErrorMessage ?? '';

            return $value;
        });

        return $logs;
    }
}