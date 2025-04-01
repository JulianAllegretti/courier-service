<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetFiledByHourAndDate\GetFiledByHourAndDateCommand;
use App\DocumentManagement\Application\Commands\GetReportFiled\GetReportFiledCommand;
use App\Shared\Application\Commands\GetReportLog\GetReportLogCommand;
use App\Shared\Application\Commands\GetReportLogPie\GetReportLogPieCommand;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/reports', name: 'app_reports')]
    public function index(): Response
    {
        return $this->render('reports/index.html.twig');
    }

    #[Route('/reports/heatmap', name: 'app_heatmap_report')]
    public function heatmap_report(): Response {
        $command = new GetFiledByHourAndDateCommand();
        $this->commandBus->dispatch($command);
        return $this->render('reports/heatmap.report.html.twig', [
            'heatmap' => $command->getResult()
        ]);
    }

    #[Route('/reports/filed', name: 'app_filed_report')]
    public function filed_report(Request $request): JsonResponse {
        $command = new GetReportFiledCommand(
            $request->get('date_start') ? new \DateTime($request->get('date_start')) : new \DateTime(),
            $request->get('date_end') ? new \DateTime($request->get('date_end')) : null
        );
        $this->commandBus->dispatch($command);
        return new JsonResponse($command->getResponse());
    }

    #[Route('/reports/log', name: 'app_log_report')]
    public function log_report(Request $request): JsonResponse {
        $command = new GetReportLogCommand(
            $request->get('date_start') ? new \DateTime($request->get('date_start')) : new \DateTime(),
            $request->get('date_end') ? new \DateTime($request->get('date_end')) : null
        );
        $this->commandBus->dispatch($command);
        return new JsonResponse($command->getResponse());
    }

    #[Route('/reports/log-pie', name: 'app_log_pie_report')]
    public function log_report_pie(Request $request): JsonResponse {
        $command = new GetReportLogPieCommand(
            $request->get('date_start') ? new \DateTime($request->get('date_start')) : new \DateTime(),
            $request->get('date_end') ? new \DateTime($request->get('date_end')) : null
        );
        $this->commandBus->dispatch($command);
        return new JsonResponse($command->getResponse());
    }
}

