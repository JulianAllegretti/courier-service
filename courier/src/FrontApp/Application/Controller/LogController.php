<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Application\Commands\GetAllLogs\GetAllLogsCommand;
use App\Shared\Application\Helpers\LogsHelper;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus,  private readonly LogsHelper $helper)
    {
    }

    #[Route('/logs', name: 'app_logs')]
    public function index(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $logs = new GetAllLogsCommand($page);
        $this->commandBus->dispatch($logs);
        $arrayLogs = iterator_to_array($logs->getLogs()->getPaginator());
        $logsFinal = $this->helper->mapLogResponse($arrayLogs);

        return $this->render('logs.html.twig', [
            'logs' => $logsFinal,
            'type' => '',
            'totalPages' =>  $logs->getLogs()->getTotalPages(),
            'page' => $page
        ]);
    }
}
