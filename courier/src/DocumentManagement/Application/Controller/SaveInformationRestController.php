<?php

namespace App\DocumentManagement\Application\Controller;

use App\DocumentManagement\Application\Services\GetFiledService;
use App\Shared\Application\ApiController;
use App\Shared\Domain\CommandBus;
use App\Shared\Domain\Exceptions\NullException;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SaveInformationRestController extends ApiController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly LoggerInterface $logger,
        private readonly GetFiledService $getFiledService
    ) {
        parent::__construct($this->commandBus, $this->logger, $this->getFiledService);
    }

    public function __invoke(Request $request): Response
    {
        $this->logger->notice('REST Request Received', [
            'username' => $_SERVER['PHP_AUTH_USER'] ?? '',
            'body' => $request->getContent(),
            'headers' => $request->headers->all()
        ]);

        $comunicacionVo = json_decode($request->getContent());

        if (empty($comunicacionVo)) {
            return new JsonResponse(['ErrorCode' => 400, 'ErrorMessage' => 'El cuerpo de la petición es requerido.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $domainResponse = $this->insertFiled($comunicacionVo, ['body' => $request->getContent()]);
        } catch (Exception $e) {
            return new JsonResponse(['ErrorCode' => $e->getCode(), 'ErrorMessage' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($domainResponse);
    }
}