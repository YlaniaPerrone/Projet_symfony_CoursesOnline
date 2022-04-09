<?php

namespace App\Controller\Trainer;

use App\Entity\Prestation;
use App\Form\PrestationType;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Security("is_granted('ROLE_TRAINER')")]
#[Route('/dashboard/trainer/prestation')]
class PrestationController extends AbstractController
{
    #[Route('/', name: 'app_trainer_prestations')]
    public function index(PrestationRepository $prestationRepository): Response
    {
        return $this->render('trainer/prestation/index.html.twig', [
            'prestations' => $prestationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trainer_prestation_new', methods: ['GET', 'POST'])]
    public function createPrestation(Request $request, EntityManagerInterface $entityManager): Response
    {

        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){
            $today = new \DateTime('now');
            $time = date('H:i');

//            dd($time);
//            dd($prestation->getStartDate() < $today );

//            dd($request->get('prestation')['days']);
//            dd($request->request->all());


            if ($prestation->getStartDate() < $today && $prestation->getEndDate() < $today){
                $this->addFlash('error', 'the date entered is less than today’s date');

            }
            if ($prestation->getEndDate() < $prestation->getStartDate() ){
                $this->addFlash('error', 'the end date is less than start date');
//                dd('inférieur');
//
            }
//            if ($prestation->getStartTime() < $time || $prestation->getendTime() < $time){
//                $this->addFlash('error', 'the hours entered is less than today’s hours');
//                dd($prestation->getStartTime() , $time);
//            }
            else{
                $prestation->setDays(implode(", ", $request->get('prestation')['days']));

                $entityManager->persist($prestation);
                $entityManager->flush();
                $this->addFlash('success', 'prestation added');

                return $this->redirectToRoute('app_trainer_prestations');
            }


        }

        return $this->renderform('trainer/prestation/new.html.twig', [
                'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_trainer_prestation_edit', methods: ['GET', 'POST'])]
    public function editPrestation(Prestation $prestation, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
//            dd($prestation->getStartTime());
            $today = new \DateTime('now');
            $time = date('H:i');

            if ($prestation->getStartDate() < $today && $prestation->getEndDate() < $today){
                $this->addFlash('error', 'the date entered is less than today’s date');

            }
            if ($prestation->getEndDate() < $prestation->getStartDate() ){
                $this->addFlash('error', 'the end date is less than start date');
//                dd('inférieur');
            }
            else{
                $entityManager->persist($prestation);
                $entityManager->flush();
                $this->addFlash('success', 'prestation added');

                return $this->redirectToRoute('app_trainer_prestations');
            }
        }

        return $this->renderform('trainer/prestation/edit.html.twig', [
                'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trainer_prestation_delete', methods: ['POST'])]
    public function delete(Request $request, Prestation $prestation, PrestationRepository $prestationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestation->getId(), $request->request->get('_token'))) {
            $prestationRepository->remove($prestation);
        }

        return $this->redirectToRoute('app_trainer_prestations');
    }

}
