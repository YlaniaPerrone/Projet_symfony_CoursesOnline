<?php

namespace App\Controller\Client;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    #[Route('/course', name: 'app_courses')]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('user/coursShow.html.twig', [
            'prestations' => $coursRepository->findAll(),
        ]);
    }
}
