<?php

namespace App\DocumentManagement\Application\Controller;

use App\DocumentManagement\Application\Commands\CreateInformation\CreateInformationCommand;
use App\DocumentManagement\Application\Commands\GetDocumentFile\GetDocumentFileCommand;
use App\DocumentManagement\Domain\Document;
use App\DocumentManagement\Domain\Comunication;
use App\DocumentManagement\Domain\Enums\PortPayment;
use App\DocumentManagement\Domain\Enums\Printed;
use App\DocumentManagement\Domain\Enums\Priority;
use App\DocumentManagement\Domain\Enums\ProcessType;
use App\DocumentManagement\Domain\Enums\TypePortPayment;
use App\DocumentManagement\Domain\Identification;
use App\DocumentManagement\Domain\Server;
use App\Shared\Application\ApiController;
use App\Shared\Application\Commands\CreateLogGetDocumentFile\CreateLogGetDocumentFileCommand;
use App\Shared\Application\Commands\CreateLogInsertInformation\CreateLogInsertInformationCommand;
use App\Shared\Domain\CommandBus;
use App\Shared\Domain\Exceptions\GetDocumentException;
use App\Shared\Domain\Exceptions\NullException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class SaveInformationController extends ApiController
{
    private Server $server;

    public function __construct(Server $server, private readonly CommandBus $commandBus, private LoggerInterface $logger)
    {
        $this->server = $server;
        parent::__construct($this->commandBus);
    }

    /**
     * @param App\DocumentManagement\Domain\Comunication $comunicacionVo
     * @return \App\DocumentManagement\Domain\Response
     * @throws NullException
     */
    public function RadicarTramite(mixed $comunicacionVo): \App\DocumentManagement\Domain\Response
    {
        $request = get_defined_vars();
        $response = new \App\DocumentManagement\Domain\Response();

        if (empty($comunicacionVo)) {
            throw new NullException("La propiedad ComunicacionVo es requerida.");
        }

        /** @var Comunication $comunicacionVo */
        try {
            $identificationObj = null;
            if (!empty($comunicacionVo->IdentificacionVo)
                && ((!empty($comunicacionVo->IdentificacionVo->Documento) && !empty($comunicacionVo->IdentificacionVo->TipoDocumento)))
            ) {
                $identificationObj = new Identification($comunicacionVo->IdentificacionVo->Documento, $comunicacionVo->IdentificacionVo->TipoDocumento);
            }

            if (!isset($comunicacionVo->Documentos->DocumentoVo)) {
                throw new NullException("La propiedad Documentos es requerida.");
            }

            $documentArray = is_array($comunicacionVo->Documentos->DocumentoVo) ? $comunicacionVo->Documentos->DocumentoVo : [$comunicacionVo->Documentos->DocumentoVo];
            if (count($documentArray) == 0) {
                throw new NullException("La propiedad documentos es requerida.");
            }

            $documentArrayObj = [];
            foreach ($documentArray as $documentItem) {
                if (empty($documentItem)) {
                    throw new NullException("La propiedad documentos es requerida");
                }
                $documentArrayObj[] = new Document(
                    $documentItem->IdDocumento, $documentItem->EndPointFilenet, $documentItem->OrdenImp, $documentItem->NumPaginas
                );
            }


            $command = new CreateInformationCommand($comunicacionVo->NumRadicado, $comunicacionVo->CodDane, $comunicacionVo->Direccion,
                $comunicacionVo->GuiaImpresa, $documentArrayObj, $comunicacionVo->NombreCompleto,
                Priority::fromName($comunicacionVo->Prioridad), Printed::fromName($comunicacionVo->Impreso),
                TypePortPayment::fromName($comunicacionVo->TipoPortePago),
                ProcessType::fromName($comunicacionVo->TipoProceso), PortPayment::fromName($comunicacionVo->PortePago),
                $comunicacionVo->Telefono, $comunicacionVo->RadicadoCasoPadre,
                $identificationObj, $comunicacionVo->Celular, $comunicacionVo->UsuarioSolicitante
            );

            $this->dispatch($command);
            $this->getDocumentFile($documentArrayObj);

            $response->setCodGuia($command->getGuideNumber());
        } catch (GetDocumentException $exception){
            $response = $this->setResponse($exception, $response, $comunicacionVo->NumRadicado);
            $commandLog = new CreateLogGetDocumentFileCommand($comunicacionVo->NumRadicado, $exception->getDocumentId(), json_encode($request), json_encode($response));
            $this->dispatch($commandLog);
        } catch (\Exception $exception) {
            $response = $this->setResponse($this->getPrevious($exception), $response, $comunicacionVo->NumRadicado);

            $commandLog = new CreateLogInsertInformationCommand($comunicacionVo->NumRadicado, json_encode($request), json_encode($response));
            $this->dispatch($commandLog);
        }

        $this->logger->notice('Response ' . $comunicacionVo->NumRadicado, [$response]);

        return $response;
    }


    public function __invoke(Request $request): Response
    {
        $this->logger->notice('Request Received', [
            'username' => $_SERVER['PHP_AUTH_USER'] ?? '',
            'password' => $_SERVER['PHP_AUTH_PW'] ?? '',
            'body' => $request->getContent(),
            'headers' => $request->headers->all()
        ]);

        return $this->server->render([
            'wsdl' => isset($_GET['wsdl']),
            'uri' => $request->getUri(),
            'handler' => $this,
            'user' => $_SERVER['PHP_AUTH_USER'] ?? '',
            'password' => $_SERVER['PHP_AUTH_PW'] ?? ''
        ]);
    }

    /**
     * @param Document[] $documents
     * @throws GetDocumentException
     */
    private function getDocumentFile(array $documents): void
    {
        $command = null;
        try {
            foreach ($documents as $document) {
                $command = new GetDocumentFileCommand($document->getIdDocumento());
                $this->dispatch($command);
            }
        } catch (\Exception $exception) {
            $e = $this->getPrevious($exception);
            $e = new GetDocumentException($e->getMessage());
            $e->setDocumentId($command->getDocumentId());
            throw $e;
        }
    }

    private function getPrevious($exception): Throwable
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        return $exception;
    }

    private function setResponse($exception, \App\DocumentManagement\Domain\Response $response, string $numRadicado) {
        $response->setNumRadicado($numRadicado);
        $response->setErrorCode($exception->getCode());
        $response->setErrorMessage($exception->getMessage());
        return $response;
    }
}