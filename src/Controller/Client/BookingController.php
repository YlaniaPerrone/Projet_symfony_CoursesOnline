<?php

namespace App\Controller\Client;

use App\Entity\Booking;
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
    #[Route('/user/booking/', name: 'app_booking')]
    public function index( SessionInterface $session, PrestationRepository $prestationRepository, EntityManagerInterface $entityManager): Response
    {
     $card = $session->get('booking', []);

     $cardWithData = [];
//     $this->getUser()->getId();
     foreach ($card as $id)
     {
         $cardWithData[] = [
                 'courses' => $prestationRepository->find($id)
         ];
     }
//        dd($cardWithData);
//
//     $booking = new Booking();
//     $booking->setUser($this->getUser());
//     $booking->setPrestation();
//     dd($booking);

//     $entityManager->persist();
//     $entityManager->flush();

     return $this->render('booking/index.html.twig', [
            'items' => $cardWithData
     ]);
    }

    #[Route('/booking/course{id}', name: 'booking_add')]
    public function add($id, SessionInterface $session): Response
    {
//        check if booking exist else create array empty
        $booking = $session->get('booking', []);

//        add product in booking by id
        $booking[$id] = 1;
//        modify card
        $session->set('booking', $booking);

//        dd($session->get('booking'));

        return $this->redirectToRoute('app_booking');
    }

    #[Route('/booking/remove/{id}', name: 'booking_remove')]
    public function remove($id, SessionInterface $session): Response
    {
//        check if booking exist else create array empty
        $booking = $session->get('booking', []);

        if (!empty($booking[$id]))
        {
            unset($booking[$id]);
        }

        $session->set('booking', $booking);

       return $this->redirectToRoute("app_booking");
    }

}
