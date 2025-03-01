<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Application\Commands\GetAllLogsDocuments\GetAllLogsDocumentsCommand;
use App\Shared\Application\Helpers\LogsHelper;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogDocumentController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus, private readonly LogsHelper $helper)
    {
    }

    #[Route('/logs-documents', name: 'app_logs_documents')]
    public function index(): Response
    {
        $documents = new GetAllLogsDocumentsCommand();
        $this->commandBus->dispatch($documents);
        $logs = $this->helper->mapLogResponse($documents->getLogs());

        return $this->render('logs.html.twig', [
            'logs' => $logs,
            'type' => 'documents'
        ]);
    }
}
