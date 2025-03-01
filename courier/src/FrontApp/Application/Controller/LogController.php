<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Application\Commands\GetAllLogs\GetAllLogsCommand;
use App\Shared\Application\Helpers\LogsHelper;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus,  private readonly LogsHelper $helper)
    {
    }

    #[Route('/logs', name: 'app_logs')]
    public function index(): Response
    {
        $documents = new GetAllLogsCommand();
        $this->commandBus->dispatch($documents);
        $logs = $this->helper->mapLogResponse($documents->getLogs());

        return $this->render('logs.html.twig', [
            'logs' => $logs,
            'type' => ''
        ]);
    }
}
