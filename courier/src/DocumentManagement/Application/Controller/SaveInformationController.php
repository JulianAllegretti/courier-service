<?php

namespace App\DocumentManagement\Application\Controller;

use App\DocumentManagement\Application\Commands\CreateInformation\CreateInformationCommand;
use App\DocumentManagement\Application\Commands\GetDocumentFile\GetDocumentFileCommand;
use App\DocumentManagement\Application\Services\GetFiledService;
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

    public function __construct(
        Server $server,
        private readonly CommandBus $commandBus,
        private readonly LoggerInterface $logger,
        private readonly GetFiledService $getFiledService
    )
    {
        $this->server = $server;
        parent::__construct($this->commandBus, $this->logger, $this->getFiledService);
    }

    /**
     * @param App\DocumentManagement\Domain\Comunication $comunicacionVo
     * @return \App\DocumentManagement\Domain\Response
     * @throws NullException
     */
    public function RadicarTramite(mixed $comunicacionVo): \App\DocumentManagement\Domain\Response
    {
        $request = get_defined_vars();
        if (empty($comunicacionVo)) {
            throw new NullException("La propiedad ComunicacionVo es requerida.");
        }

        return $this->insertFiled($comunicacionVo, $request);
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
}