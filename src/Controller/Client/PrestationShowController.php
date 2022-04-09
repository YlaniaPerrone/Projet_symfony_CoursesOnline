<?php

namespace App\Controller\Client;

use App\Entity\Prestation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestationShowController extends AbstractController
{
    #[Route('/prestation/show/{id}', name: 'prestation', methods: ['GET'])]
    public function index(Prestation $prestation): Response
    {
        return $this->render('user/showPrestation.html.twig', [
            'prestation' => $prestation,
        ]);
    }


}
