<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetFiled\GetFiledCommand;
use App\DocumentManagement\Application\Commands\GetFiledById\GetFiledByIdCommand;
use App\Shared\Application\Helpers\CSVHelper;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class FiledController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus, private readonly CSVHelper $helper)
    {
    }

    #[Route('/filed', name: 'app_filed')]
    public function index(Request $request): Response
    {
        $params = $request->query->all();
        $page = $request->query->get('page', 1);
        $filed = new GetFiledCommand($page, $params);
        $this->commandBus->dispatch($filed);

        if (isset($params['csv']) && $params['csv'] === "true") {
            $response = $this->helper->downloadCSVFiled($filed->getFiled()->getPaginator());
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');
            return $response;
        }

        return $this->render('filed/index.html.twig', [
            'filed' =>  $filed->getFiled()->getPaginator(),
            'totalPages' =>  $filed->getFiled()->getTotalPages(),
            'page' => $page,
            'params' => $params,
        ]);
    }

    #[Route('/filed/{id_filed}', name: 'app_filed_by_id')]
    public function show(int $id_filed): Response
    {
        $command = new GetFiledByIdCommand($id_filed);
        $this->commandBus->dispatch($command);

        if (is_null($command->getFiled()) || is_null($command->getIdFiled())) {
            $this->addFlash('error', 'El Radicado no existe');
            return $this->redirect('/filed');
        }

        $date=date_create($command->getFiled()->getCreatedAt());
        $request = '';
        try {
            $commandServer = 'grep -r "'.$command->getFiled()->getNumRadicado().'" /var/www/symfony/var/log/'.$this->getParameter('app_env').'-request-'.date_format($date,"Y-m-d").'.log';
            exec($commandServer, $output);
            foreach ($output as $line) {
                $request.= $line . "\n";
            }
        }catch (\Exception $e) {}

        $logs = $command->getLogsInsert();
        foreach ($logs as &$log) {
            $log['request'] = json_decode(trim($log['request']));
            $log['error'] = json_decode(trim($log['error']));
        }

        $logsDocuments = $command->getLogsGetDocuments();
        foreach ($logsDocuments as &$log) {
            $log['request'] = json_decode(trim($log['request']));
            $log['error'] = json_decode(trim($log['error']));
        }

        return $this->render('filed/show.html.twig', [
            'filed' => $command->getFiled(),
            'logsInsert' => $logs,
            'logsDocuments' => $logsDocuments,
            'request' => $request
        ]);
    }
}
