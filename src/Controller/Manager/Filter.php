<?php

namespace App\Controller\Manager;

use App\Repository\CategoryRepository;
use App\Repository\TrainerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Filter extends AbstractController
{


    #[Route('', name: 'app_manager_trainer_isActive', methods: ['POST', 'GET'])]
    public function filterTrainerActive(TrainerRepository $trainerRepository): Response
    {
        return $this->render('manager/filter.html.twig', [
            'trainers' => $trainerRepository->findBy(
                [ 'isActive' => true]
            ),
        ]);
    }



}