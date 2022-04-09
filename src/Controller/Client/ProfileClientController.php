<?php

namespace App\Controller\Client;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileClientController extends AbstractController
{
    #[Route('/profile', name: 'profile_client')]
    public function index(): Response
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('profile/coursShow.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user->get()
        ]);
    }
    #[Route('client/edit/{id}', name: 'editClient',  methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager)
    {

        if ($this->getUser() !== $user)
        {
            $this->redirectToRoute('home');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($user);
//            $entityManager->persist($user);
//            $entityManager->flush();
//
        }
        return $this->renderForm('profile\edit.html.twig', [
                'form' => $form,
                'user' => $user
        ]);
    }
}
