<?php

namespace App\Controller\Client;

use App\Entity\Prestation;
use App\Repository\CategoryRepository;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestationController extends AbstractController
{
    #[Route('/prestation', name: 'app_prestation', methods: ['GET'])]
    public function index( PrestationRepository $prestationRepository, CategoryRepository $categoryRepository ): Response
    {
//        dd($prestationRepository->find($id));

        return $this->render('user/prestation.html.twig', [
            'prestations' => $prestationRepository->findAll(),
            'categories' => $categoryRepository->findAll()

        ]);
    }

    #[Route('/prestation/show/{id}', name: 'prestation_show', methods: ['GET'])]
    public function show(int $id, PrestationRepository $prestationRepository ): Response
    {
//        dd($prestationRepository->find($id));

        return $this->render('user/showPrestation.html.twig', [
            'prestation' => $prestationRepository->find($id),
        ]);
    }

}
