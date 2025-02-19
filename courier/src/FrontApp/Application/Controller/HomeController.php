<?php

namespace App\FrontApp\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'front_app_main')]
    public function index(): RedirectResponse
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        return $this->redirectToRoute('login');
    }
}
