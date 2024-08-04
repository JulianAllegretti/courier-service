<?php

namespace App\DocumentManagement\Infrastructure;

use App\DocumentManagement\Domain\Client;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\Security;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\System;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\ContextDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\DetailDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\RequestDTO;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\RequestDTO as RequestHeader;
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
        try {
            $body = new RequestDTO(
                new ContextDTO($this->user_service, $this->user_service_system, $this->password_service),
                new DetailDTO($data['DocumentId'])
            );

            $header = new RequestHeader(
                new Security('',''),
                new System($this->application_id, $this->transaction_id)
            );

            $params = ["tipoIdentificacionDocumentoDTO" => $body, 'Header' => $header];
            $params = array(
                'param1' => 'value1',
                'param2' => 'value2'
            );
            $response = $client->__soapCall("ObtenerDocumento", array($params));

            $requestXML = $client->__getLastRequest();
            // Imprimir el XML de la solicitud
            echo "XML de la solicitud:\n" . htmlentities($requestXML) . "\n";

            var_dump($response);
            die();
        } catch (\Exception $e) {
            $requestXML = $client->__getLastRequest();
            // Imprimir el XML de la solicitud
            var_dump(htmlentities($requestXML));
            var_dump($e->getMessage());
            die();
        }
    }
}