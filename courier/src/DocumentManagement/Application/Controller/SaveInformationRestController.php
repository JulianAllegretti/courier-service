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
        private readonly GetFiledService $getFiledService,
        private readonly string $appUser,
        private readonly string $appPassword
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

        if (!$this->authenticate($request)) {
            return new JsonResponse(['ErrorCode' => 401, 'ErrorMessage' => 'No autorizado.'], Response::HTTP_UNAUTHORIZED, ['WWW-Authenticate' => 'Basic realm="CourierService"']);
        }

        $comunicacionVo = json_decode($request->getContent());

        if (empty($comunicacionVo)) {
            return new JsonResponse(['ErrorCode' => 400, 'ErrorMessage' => 'El cuerpo de la petición es requerido.'], Response::HTTP_BAD_REQUEST);
        }

        if (empty($comunicacionVo->numeroRadicado)) {
            return new JsonResponse(['ErrorCode' => 400, 'ErrorMessage' => 'La propiedad numeroRadicado es requerida.'], Response::HTTP_BAD_REQUEST);
        }

        $comunicacionVo = SaveInformationRestMapper::map($comunicacionVo);

        $domainResponse = $this->insertFiled($comunicacionVo, ['body' => $request->getContent()]);

        if ($domainResponse->getErrorCode() !== null) {
            return new JsonResponse($domainResponse, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($domainResponse);
    }

    private function authenticate(Request $request): bool
    {
        $user     = $_SERVER['PHP_AUTH_USER'] ?? '';
        $password = $_SERVER['PHP_AUTH_PW']   ?? '';

        // Fallback para Nginx+FPM donde PHP_AUTH_* no se populan automáticamente
        if ($user === '') {
            $authorization = $request->headers->get('Authorization', '');
            if (str_starts_with($authorization, 'Basic ')) {
                [$user, $password] = explode(':', base64_decode(substr($authorization, 6)), 2) + ['', ''];
            }
        }

        return $user === $this->appUser && $password === $this->appPassword;
    }
}