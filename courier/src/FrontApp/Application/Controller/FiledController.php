<?php

namespace App\FrontApp\Application\Controller;

use App\DocumentManagement\Application\Commands\GetFiled\GetFiledCommand;
use App\Shared\Domain\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FiledController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/filed', name: 'app_filed')]
    public function index(): Response
    {
        $filed = new GetFiledCommand();
        $this->commandBus->dispatch($filed);
        return $this->render('filed.html.twig', [
            'filed' => $filed->getFiled()
        ]);
    }
}
