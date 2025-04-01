<?php

namespace App\FrontApp\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function admin(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            exec('/usr/local/bin/php -d memory_limit=256M bin/console app:generate-report '.$data['time_start'].' '.$data['time_end'].' '.$data['difference_days'].' --env='.$this->getParameter('app_env'));
            $this->addFlash('warning', 'El cron corrió exitosamente');
        }

        return $this->render('admin.html.twig', [
            'time_start' => $this->getParameter('time_start'),
            'time_end' => $this->getParameter('time_end'),
            'difference_days' => $this->getParameter('difference_days'),
        ]);
    }
}
