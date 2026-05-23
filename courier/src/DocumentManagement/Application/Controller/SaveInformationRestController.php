<?php

namespace App\DocumentManagement\Application\Controller;

use App\DocumentManagement\Application\Mapper\SaveInformationRestMapper;
use App\DocumentManagement\Application\Services\GetFiledService;
use App\Shared\Application\ApiController;
use App\Shared\Domain\CommandBus;
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

        if (!isset($comunicacionVo->NumRadicado)) {
            return new JsonResponse(['ErrorCode' => 400, 'ErrorMessage' => 'La propiedad NumRadicado es requerida.'], Response::HTTP_BAD_REQUEST);
        }

        $comunicacionVo = SaveInformationRestMapper::map($comunicacionVo);

        $domainResponse = $this->insertFiled($comunicacionVo, ['body' => $request->getContent()]);

        if ($domainResponse->getErrorCode() !== null) {
            return new JsonResponse($domainResponse, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($domainResponse);
    }
}