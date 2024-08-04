<?php

namespace App\DocumentManagement\Infrastructure;

use App\DocumentManagement\Domain\Client;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\Security;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\System;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Request;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\RequestDTO as RequestHeader;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\RequestDTO;
use SoapClient;

readonly class ClientSoap implements Client
{

    public function __construct(private string $url_service, private string $user_service, private string $user_service_system, private string $password_service, private string $application_id, private string $transaction_id)
    {
    }

    /**
     * @throws \SoapFault
     */
    function get(array $data): void
    {
        $client = new SoapClient($this->url_service."?wsdl");
        $body = new RequestDTO(
            new ContextDTO($this->user_service, $this->user_service_system, $this->password_service),
            new Request($data['DocumentId'])
        );

        $header = new RequestHeader(
            new Security('',''),
            new System($this->application_id, $this->transaction_id)
        );

        $params = ["tipoIdentificacionDocumentoDTO" => $body, 'Header' => $header];
        $response = $client->__soapCall("ObtenerDocumento", array($params));
        var_dump($response);
        die();
    }
}