<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetAllDocuments\GetAllDocumentsCommand;
use App\DocumentManagement\Application\Commands\GetFiled\GetFiledCommand;
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
        $page = $request->query->get('page', 1);
        $documents = new GetAllDocumentsCommand($page);
        $this->commandBus->dispatch($documents);
        return $this->render('documents.html.twig', [
            'documents' =>  $documents->getDocuments()->getPaginator(),
            'totalPages' =>  $documents->getDocuments()->getTotalPages(),
            'page' => $page
        ]);
    }
}
