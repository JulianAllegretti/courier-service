<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetFiled\GetFiledCommand;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FiledController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/filed', name: 'app_filed')]
    public function index(Request $request): Response
    {
        $params = $request->query->all();
        $page = $request->query->get('page', 1);
        $filed = new GetFiledCommand($page, $params);
        $this->commandBus->dispatch($filed);
        return $this->render('filed.html.twig', [
            'filed' =>  $filed->getFiled()->getPaginator(),
            'totalPages' =>  $filed->getFiled()->getTotalPages(),
            'page' => $page,
            'params' => $params,
        ]);
    }
}
