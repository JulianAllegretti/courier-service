<?php

namespace App\DocumentManagement\Application\Commands\GetDocumentFile;

use App\DocumentManagement\Domain\Client;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\RequestDTO as RequestHeader;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\Security;
use App\DocumentManagement\Domain\Entity\SoapRequest\Header\System;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Contexto;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\Detalle;
use App\DocumentManagement\Domain\Entity\SoapRequest\IdentificationTypeDocument\RequestDTO;
use App\DocumentManagement\Domain\Repository\DocumentRepository;
use App\Shared\Domain\CommandHandler;
use App\Shared\Domain\Exceptions\DocumentInvalidException;

readonly class GetDocumentFileCommandHandler implements CommandHandler
{
    public function __construct(
        private Client $client,
        private DocumentRepository $repository,
        private string $url_service,
        private string $user_service,
        private string $user_service_system,
        private string $password_service,
        private string $application_id,
        private string $transaction_id
    )
    {
    }

    /**
     * @throws DocumentInvalidException
     */
    public function __invoke(GetDocumentFileCommand $command): void
    {
        try {
            $body = new RequestDTO(
                new Contexto($this->user_service, $this->user_service_system, $this->password_service),
                new Detalle($command->getDocumentId())
            );

            $header = new RequestHeader(
                new Security('',''),
                new System($this->application_id, $this->transaction_id)
            );

            $params = ["tipoIdentificacionDocumentoDTO" => $body, 'Header' => $header];

            $response = $this->client->get($this->url_service."?wsdl", "ObtenerDocumento", [$params]);
            if (empty($response->DocumentoDTO->Detalle->contenido)) {
                throw new DocumentInvalidException('El documento es invalido');
            }
            $pdf_decoded = base64_decode($response->DocumentoDTO->Detalle->contenido);
            $pdf = fopen('files/'.$command->getDocumentId().'.pdf','w');
            fwrite ($pdf, $pdf_decoded);
            fclose ($pdf);

            $this->repository->updatePathFile($command->getDocumentId());
        } catch (DocumentInvalidException $e){
            throw $e;
        } catch (\Exception $e) {
            throw new DocumentInvalidException($e->getMessage());
        }
    }
}