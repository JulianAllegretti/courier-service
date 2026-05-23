<?php

namespace App\Shared\Application;

use App\DocumentManagement\Application\Commands\CreateInformation\CreateInformationCommand;
use App\DocumentManagement\Application\Commands\GetDocumentFile\GetDocumentFileCommand;
use App\DocumentManagement\Domain\Comunication;
use App\DocumentManagement\Domain\Document;
use App\DocumentManagement\Domain\Enums\PortPayment;
use App\DocumentManagement\Domain\Enums\Printed;
use App\DocumentManagement\Domain\Enums\Priority;
use App\DocumentManagement\Domain\Enums\ProcessType;
use App\DocumentManagement\Domain\Enums\TypePortPayment;
use App\DocumentManagement\Domain\Identification;
use App\Shared\Application\Commands\CreateLogGetDocumentFile\CreateLogGetDocumentFileCommand;
use App\Shared\Application\Commands\CreateLogInsertInformation\CreateLogInsertInformationCommand;
use App\Shared\Domain\Command;
use App\Shared\Domain\CommandBus;
use App\Shared\Domain\Exceptions\GetDocumentException;
use App\Shared\Domain\Exceptions\NullException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

class ApiController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly LoggerInterface $logger
    ) {}

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function insertFiled(mixed $comunicacionVo, array $request): \App\DocumentManagement\Domain\Response
    {
        /** @var Comunication $comunicacionVo */
        $response = new \App\DocumentManagement\Domain\Response();

        try {
            $identificationObj = null;
            if (!empty($comunicacionVo->IdentificacionVo)
                && ((!empty($comunicacionVo->IdentificacionVo->Documento) && !empty($comunicacionVo->IdentificacionVo->TipoDocumento)))
            ) {
                $identificationObj = new Identification($comunicacionVo->IdentificacionVo->Documento, $comunicacionVo->IdentificacionVo->TipoDocumento);
            }

            if (!isset($comunicacionVo->Documentos)) {
                throw new NullException("La propiedad Documentos es requerida.");
            }

            $documentArray = is_array($comunicacionVo->Documentos) ? $comunicacionVo->Documentos : [$comunicacionVo->Documentos];
            if (count($documentArray) == 0) {
                throw new NullException("La propiedad documentos es requerida.");
            }

            $documentArrayObj = [];
            foreach ($documentArray as $documentItem) {
                if (empty($documentItem)) {
                    throw new NullException("La propiedad documentos es requerida");
                }
                $documentArrayObj[] = new Document(
                    $documentItem->IdDocumento, $documentItem->EndPointFilenet, $documentItem->OrdenImp, $documentItem->NumPaginas, $documentItem->NombreArchivo ?? null
                );
            }


            $command = new CreateInformationCommand($comunicacionVo->NumRadicado, $comunicacionVo->CodDane, $comunicacionVo->Direccion,
                $comunicacionVo->GuiaImpresa, $documentArrayObj, $comunicacionVo->NombreCompleto,
                Priority::fromName($comunicacionVo->Prioridad), Printed::fromName($comunicacionVo->Impreso),
                TypePortPayment::fromName($comunicacionVo->TipoPortePago),
                ProcessType::fromName($comunicacionVo->TipoProceso), PortPayment::fromName($comunicacionVo->PortePago),
                $comunicacionVo->Telefono, $comunicacionVo->RadicadoCasoPadre,
                $identificationObj, $comunicacionVo->Celular, $comunicacionVo->UsuarioSolicitante, $comunicacionVo->NumTramite,
                $comunicacionVo->EventName ?? null, $comunicacionVo->IdCase ?? null
            );

            $this->dispatch($command);
            if (!$command->isAlreadyExist()) {
                $this->getDocumentFile($documentArrayObj, $command->getGuideNumber());
            }

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

        $response->setNumTramite($comunicacionVo->NumTramite);
        $this->logger->notice('Response ' . $comunicacionVo->NumRadicado, [$response]);

        return $response;
    }

    private function setResponse($exception, \App\DocumentManagement\Domain\Response $response, string $numRadicado): \App\DocumentManagement\Domain\Response
    {
        $response->setNumRadicado($numRadicado);
        $response->setErrorCode($exception->getCode());
        $response->setErrorMessage($exception->getMessage());
        return $response;
    }

    /**
     * @param Document[] $documents
     * @throws GetDocumentException
     */
    private function getDocumentFile(array $documents, string $guideNumber): void
    {
        $command = null;
        try {
            foreach ($documents as $document) {
                $command = new GetDocumentFileCommand($document->getIdDocumento(), $guideNumber);
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
}