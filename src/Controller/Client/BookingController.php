<?php

namespace App\Controller\Client;

use App\Entity\Booking;
use App\Entity\Prestation;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

//#[Security("is_granted('IS_AUTHENTICATED_FULLY')")]
class BookingController extends AbstractController
{
    #[Route('/card/{id}', name: 'app_card')]
    public function index(int $id, PrestationRepository $prestationRepository): Response
    {
        return $this->render('user/booking/index.html.twig', [
            'item' => $prestationRepository->find($id)
        ]);
    }

    #[Route('/bookind', name: 'app_booking')]
    public function booking(PrestationRepository $prestationRepository): Response
    {

//        return $this->render('user/booking/index.html.twig', [
//
//        ]);
    }

}
