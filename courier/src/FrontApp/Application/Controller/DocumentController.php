<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetAllDocuments\GetAllDocumentsCommand;
use App\DocumentManagement\Application\Commands\GetDocumentById\GetDocumentByIdCommand;
use App\DocumentManagement\Application\Commands\GetFiled\GetFiledCommand;
use App\DocumentManagement\Application\Commands\GetFiledById\GetFiledByIdCommand;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DocumentController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/documents', name: 'app_documents')]
    public function index(Request $request): Response
    {
        $params = $request->query->all();
        $page = $request->query->get('page', 1);
        $documents = new GetAllDocumentsCommand($page, $params);
        $this->commandBus->dispatch($documents);
        return $this->render('documents/index.html.twig', [
            'documents' =>  $documents->getDocuments()->getPaginator(),
            'totalPages' =>  $documents->getDocuments()->getTotalPages(),
            'page' => $page,
            'params' => $params,
        ]);
    }

    #[Route('/document/{id_document}', name: 'app_document_by_id')]
    public function show(int $id_document): Response
    {
        $command = new GetDocumentByIdCommand($id_document);
        $this->commandBus->dispatch($command);

        if (is_null($command->getDocument()) || is_null($command->getDocumentId())) {
            $this->addFlash('error', 'El Documento no existe');
            return $this->redirect('/documents');
        }

        $logsDocuments = $command->getLogs();
        foreach ($logsDocuments as &$log) {
            $log['request'] = json_decode(trim($log['request']));
            $log['error'] = json_decode(trim($log['error']));
        }

        return $this->render('documents/show.html.twig', [
            'document' => $command->getDocument(),
            'logsDocuments' => $logsDocuments
        ]);
    }
}
