<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
//    #[Route('/user', name: 'home_user')]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'prestations' => $coursRepository->findAll(),
        ]);
    }
}
