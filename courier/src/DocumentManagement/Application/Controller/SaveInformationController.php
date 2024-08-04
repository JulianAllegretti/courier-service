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
     * @param string $numRadicado
     * @param string $codeDane
     * @param string $direccion
     * @param string $guiaImpresa
     * @param App\DocumentManagement\Domain\Document[] $documentos
     * @param string $nombreCompleto
     * @param string $prioridad
     * @param string $tipoProceso *
     * @param string $impreso *
     * @param string $tipoPortePago *
     * @param string $portePago *
     * @param string $celular
     * @param string $telefono
     * @param App\DocumentManagement\Domain\Identification | null $identificacion
     * @param string $radicadoCasoPadre
     * @param string $usuarioSolicitante
     * @return \App\DocumentManagement\Domain\Response
     */
    public function RadicarTramite(string $numRadicado, string $codeDane, string $direccion, string $guiaImpresa,
                                    mixed $documentos, string $nombreCompleto, string $prioridad, string $tipoProceso,
                                    string $impreso, string $tipoPortePago, string $portePago,
                                    string $celular = '', string $telefono = '', mixed $identificacion = null,
                                    string $radicadoCasoPadre = '', string $usuarioSolicitante = ''
    ): \App\DocumentManagement\Domain\Response
    {
        $request = get_defined_vars();
        $response = new \App\DocumentManagement\Domain\Response();

        try {
            $identificationObj = null;
            if (!empty($identificacion)
                && ((!empty($identificacion->documento) && !empty($identificacion->tipoDocumento)))
            ) {
                $identificationObj = new Identification($identificacion->documento, $identificacion->tipoDocumento);
            }

            if (!isset($documentos->item)) {
                throw new NullException("La propiedad Documentos es requerida.");
            }

            $documentArray = is_array($documentos->item) ? $documentos->item : [$documentos->item];
            if (count($documentArray) == 0) {
                throw new NullException("La propiedad documentos es requerida.");
            }

            $documentArrayObj = [];
            foreach ($documentArray as $documentItem) {
                if (empty($documentItem)) {
                    throw new NullException("La propiedad documentos es requerida");
                }
                $documentArrayObj[] = new Document(
                    $documentItem->idDocumento, $documentItem->endPointFileNet, $documentItem->ordenImp, $documentItem->numPaginas
                );
            }

            $command = new CreateInformationCommand($numRadicado, $codeDane, $direccion, $guiaImpresa, $documentArrayObj, $nombreCompleto,
                Priority::fromName($prioridad), Printed::fromName($impreso), TypePortPayment::fromName($tipoPortePago),
                ProcessType::fromName($tipoProceso), PortPayment::fromName($portePago),
                $telefono, $radicadoCasoPadre, $identificationObj, $celular, $usuarioSolicitante
            );

            $this->dispatch($command);
            $this->getDocumentFile($documentArrayObj);

            $response->setCodGuia($command->getGuideNumber());
        } catch (GetDocumentException $exception){
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