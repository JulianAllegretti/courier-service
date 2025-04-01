<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Application\Commands\GetAllLogsDocuments\GetAllLogsDocumentsCommand;
use App\Shared\Application\Commands\GetLogById\GetLogByIdCommand;
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
        $params = $request->query->all();
        $page = $request->query->get('page', 1);
        $logs = new GetAllLogsDocumentsCommand($page, $params);
        $this->commandBus->dispatch($logs);
        $arrayLogs = iterator_to_array($logs->getLogs()->getPaginator());
        $logsFinal = $this->helper->mapLogResponse($arrayLogs, true);

        return $this->render('logs/index.html.twig', [
            'logs' => $logsFinal,
            'type' => 'documents',
            'totalPages' =>  $logs->getLogs()->getTotalPages(),
            'page' => $page,
            'params' => $params,
            'url' => 'document-log'
        ]);
    }

    #[Route('/log-document/{log_id}', name: 'app_log_document_by_id')]
    public function show(int $log_id): Response
    {
        $command = new GetLogByIdCommand('document', $log_id);
        $this->commandBus->dispatch($command);

        return $this->render('logs/show.html.twig', [
            'log' => $command->getLog(),
            'type' => 'document'
        ]);
    }
}
