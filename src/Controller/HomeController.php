<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Repository\CoursRepository;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
//    #[Route('/user', name: 'home_user')]
    public function index(PrestationRepository $prestationRepository): Response
    {

//        dd($prestationRepository->showPrestation());
        return $this->render('home/index.html.twig', [
            'prestations' => $prestationRepository->showPrestation(),
        ]);
    }





}
