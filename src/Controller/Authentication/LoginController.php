<?php

namespace App\Controller\Authentication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    #[Route('/auth/login', name: 'app_trainer_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
          return $this->render('Authentication/login/index.html.twig', [
              'last_username' => $lastUsername,
              'error'         => $error,
          ]);
      }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
