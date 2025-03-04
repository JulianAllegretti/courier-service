<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Application\Commands\GetAllLogsDocuments\GetAllLogsDocumentsCommand;
use App\Shared\Application\Helpers\LogsHelper;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogDocumentController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus, private readonly LogsHelper $helper)
    {
    }

    #[Route('/logs-documents', name: 'app_logs_documents')]
    public function index(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $logs = new GetAllLogsDocumentsCommand($page);
        $this->commandBus->dispatch($logs);
        $arrayLogs = iterator_to_array($logs->getLogs()->getPaginator());
        $logsFinal = $this->helper->mapLogResponse($arrayLogs, true);

        return $this->render('logs.html.twig', [
            'logs' => $logsFinal,
            'type' => 'documents',
            'totalPages' =>  $logs->getLogs()->getTotalPages(),
            'page' => $page
        ]);
    }
}
