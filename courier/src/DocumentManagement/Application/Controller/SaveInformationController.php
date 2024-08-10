<?php

namespace App\DocumentManagement\Application\Controller;

use App\DocumentManagement\Application\Commands\CreateInformation\CreateInformationCommand;
use App\DocumentManagement\Application\Commands\GetDocumentFile\GetDocumentFileCommand;
use App\DocumentManagement\Domain\Document;
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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

final class SaveInformationController extends ApiController
{
    private Server $server;

    public function __construct(Server $server, private readonly CommandBus $commandBus)
    {
        $this->server = $server;
        parent::__construct($this->commandBus);
    }


    /**
     * @param string $codeDane
     * @param string $direccion
     * @param string $listaDocumentos
     * @param string $urlVerDocumento
     * @param string $identificacion
     * @param string $nombreCompleto
     * @param string $prioridad
     * @param bool $impreso
     * @param bool $portePago
     * @param int $tipoPortePago
     * @param int $tipoProceso
     * @param string $numeroDocumento
     * @param string $tipoDocumento
     * @param string $tramite
     * @param string $subtramite
     * @param string $asunto
     * @param int $tipoEnvio
     * @param string $serie
     * @param string $subSerie
     * @param string $inputSystem
     * @param string $applicationID
     * @param string $transactionID
     * @param string $idCase
     * @param string $numRadicado
     * @param string $eventoInvocado
     * @param string $nombreProceso
     * @param string $trace
     * @param string|null $guiaImpresa
     * @param string|null $celular
     * @param string|null $telefono
     * @return \App\DocumentManagement\Domain\Response
     */
    public function PeticionEnvioInfoCourier(string $codeDane, string $direccion, string $listaDocumentos, string $urlVerDocumento,
                                             string $identificacion, string $nombreCompleto, string $prioridad, bool $impreso, bool $portePago, int $tipoPortePago, int $tipoProceso,
                                             string $numeroDocumento = '', string $tipoDocumento = '', string $tramite = '', string $subtramite = '',
                                             string $asunto = '', int $tipoEnvio = -1, string $serie = '', string $subSerie = '',
                                             string $inputSystem = '', string $applicationID = '', string $transactionID = '', string $idCase = '',
                                             string $numRadicado = '', string $eventoInvocado = '', string $nombreProceso = '', string $trace = '',
                                             ?string $guiaImpresa = '', ?string $celular = '', ?string $telefono = ''
    ): \App\DocumentManagement\Domain\Response
    {
        $request = get_defined_vars();
        $response = new \App\DocumentManagement\Domain\Response();

        try {
            $identificationObj = null;
            if ((!empty($numeroDocumento) && !empty($tipoDocumento))
            ) {
                $identificationObj = new Identification($numeroDocumento, $tipoDocumento);
            }

            if (empty($listaDocumentos) || empty($urlVerDocumento)) {
                throw new NullException("La propiedad ListaDocumentos o UrlVerDocumento es requerida.");
            }

            $document = new Document($listaDocumentos, $urlVerDocumento);

            $command = new CreateInformationCommand($numRadicado, $codeDane, $direccion, $guiaImpresa, $document, $nombreCompleto,
                Priority::fromName($prioridad), Printed::fromValue($impreso ? '1' : '0'), TypePortPayment::fromValue($tipoPortePago),
                ProcessType::fromValue($tipoProceso), PortPayment::fromValue($portePago ? '1' : '0'),
                $telefono, $tramite, $identificationObj, $celular, $subtramite, $asunto, $tipoEnvio, $serie, $subSerie,
                $inputSystem, $applicationID, $transactionID, $idCase, $eventoInvocado, $nombreProceso, $trace
            );

            $this->dispatch($command);
            $this->getDocumentFile($document);

            $response->setCodGuia($command->getGuideNumber());
        } catch (GetDocumentException $exception) {
            $response = $this->setResponse($exception, $response, $numRadicado);
            $commandLog = new CreateLogGetDocumentFileCommand($numRadicado, $exception->getDocumentId(), json_encode($request), json_encode($response));
            $this->dispatch($commandLog);
        } catch (\Exception $exception) {
            $response = $this->setResponse($this->getPrevious($exception), $response, $numRadicado);

            $commandLog = new CreateLogInsertInformationCommand($numRadicado, json_encode($request), json_encode($response));
            $this->dispatch($commandLog);
        }

        return $response;
    }


    public function __invoke(Request $request): Response
    {
        return $this->server->render([
            'wsdl' => isset($_GET['wsdl']),
            'uri' => $request->getUri(),
            'handler' => $this,
            'user' => $_SERVER['PHP_AUTH_USER'] ?? '',
            'password' => $_SERVER['PHP_AUTH_PW'] ?? ''
        ]);
    }

    /**
     * @param Document $document
     * @throws GetDocumentException
     */
    private function getDocumentFile(Document $document): void
    {
        $command = null;
        try {
            $command = new GetDocumentFileCommand($document->getIdDocumento());
            $this->dispatch($command);
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

    private function setResponse($exception, \App\DocumentManagement\Domain\Response $response, string $numRadicado)
    {
        $response->setNumRadicado($numRadicado);
        $response->setErrorCode($exception->getCode());
        $response->setErrorMessage($exception->getMessage());
        return $response;
    }
}