<?php

namespace App\DocumentManagement\Domain;

class ResponseWrap
{
    /**
     * @var Response
     */
    public Response $RadicarTramiteResult;

    /**
     * @param Response $RadicarTramiteResult
     */
    public function __construct(Response $RadicarTramiteResult)
    {
        $this->RadicarTramiteResult = $RadicarTramiteResult;
    }

    public function getRadicarTramiteResult(): Response
    {
        return $this->RadicarTramiteResult;
    }

    public function setRadicarTramiteResult(Response $RadicarTramiteResult): void
    {
        $this->RadicarTramiteResult = $RadicarTramiteResult;
    }
}