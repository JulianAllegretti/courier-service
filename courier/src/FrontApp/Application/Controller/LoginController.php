<?php

namespace App\FrontApp\Application\Controller;

use App\Shared\Domain\Constants\Errors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'front_app_login')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('login.html.twig');
        }
        $validationErrors = $this->validateRequest($request);
        if ($validationErrors->count() > 0) {
            $this->addFlash('error', Errors::$badRequest);
            return $this->redirectToRoute('login');
        }

        return $this->render('login.html.twig');
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface {
        $constraint = new Collection([
            'email' => [new NotBlank(), new Email()],
            'password' => [new NotBlank()]
        ]);

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }
}
