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
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use function Symfony\Component\String\b;

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
        private string $transaction_id,
        private string $app_env,
    )
    {
    }

    /**
     * @throws DocumentInvalidException
     */
    public function __invoke(GetDocumentFileCommand $command): void
    {
        try {
            switch ($this->app_env){
                case 'dev':
                    $this->repository->updatePathFile($command->getDocumentId(), $command->getGuideNumber());
                    break;
                case 'staging':
                    $this->downloadForQA($command);
                    break;
                case 'prod':
                    $this->downloadForProd($command);
                    break;
                default:
                    return;
            }
        } catch (DocumentInvalidException $e){
            throw $e;
        } catch (\Exception $e) {
            throw new DocumentInvalidException($e->getMessage());
        }
    }

    private function downloadForQA($command): void
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

        $response = $this->client->get($this->url_service."?wsdl", "ObtenerDocumento", [$params]);
        if (empty($response->DocumentoDTO->Detalle->contenido)) {
            throw new DocumentInvalidException('El documento es invalido');
        }
        $pdf_decoded = base64_decode($response->DocumentoDTO->Detalle->contenido);
        $pdf = fopen('files/'.$command->getDocumentId().'.pdf','w');
        fwrite ($pdf, $pdf_decoded);
        fclose ($pdf);
        $this->repository->updatePathFile($command->getDocumentId(), $command->getGuideNumber());
    }

    /**
     * @throws DocumentInvalidException
     */
    private function downloadForProd($command): void
    {
        $attempts = 0;
        $shCommand = '';
        $output = '';
        $statusCode = 0;
        while ($attempts<20) {
            $folder = '/var/www/symfony/public/files/';
            $id = $command->getDocumentId().'.pdf';

            if (file_exists($folder.$id)) {
                $this->repository->updatePathFile($command->getDocumentId(), $command->getGuideNumber());
                break;
            }

            $url = $this->url_service."/".$command->getDocumentId();
            $shCommand = "bash /var/www/symfony/download.sh '$url' '$folder' '$id'";
            exec($shCommand, $output, $statusCode);

            if ($statusCode !== 0) {
                $attempts++;
                continue;
            }

            if (file_exists($command->getDocumentId())) {
                unlink($command->getDocumentId());
            }

            $this->repository->updatePathFile($command->getDocumentId(), $command->getGuideNumber());
            break;
        }

        if ($attempts >= 20 && $statusCode !== 0) {
            throw new DocumentInvalidException('Error al descargar el archivo. Código de estado: ' . $statusCode . " Comando: " .$shCommand. " Error: ".json_encode($output));
        }
    }
}