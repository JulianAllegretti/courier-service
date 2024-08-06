<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentFile;

use App\DocumentManagement\Domain\Client;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\RequestDTO as RequestHeader;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\Security;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\System;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Contexto;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Detalle;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\RequestDTO;
use App\Shared\Domain\CommandHandler;

readonly class GetDocumentFileCommandHandler implements CommandHandler
{
    public function __construct(
        private Client $client,
        private string $url_service,
        private string $user_service,
        private string $user_service_system,
        private string $password_service,
        private string $application_id,
        private string $transaction_id
    )
    {
    }

    public function __invoke(GetDocumentFileCommand $command): void
    {
        $body = new RequestDTO(
            new Contexto($this->user_service, $this->user_service_system, $this->password_service),
            new Detalle($command->getDocumentId())
        );

        $header = new RequestHeader(
            new Security('',''),
            new System($this->application_id, $this->transaction_id)
        );

        $params = ["tipoIdentificacionDocumentoDTO" => $body, 'Header' => $header];

        $response = $this->client->get($this->url_service."?wsdl", "ObtenerDocumento", $params);
        var_dump($response);
        die();
    }
}