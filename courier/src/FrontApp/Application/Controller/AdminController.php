<?php

namespace App\FrontApp\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function admin(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your admin controller!',
            'path' => 'src/Controller/App/FrontApp/Application/Controller/LoginController.php',
        ]);
    }
}
