<?php

namespace App\Controller\Trainer;

use App\Entity\Cours;
use App\Entity\User;
use App\Form\CoursType;
use App\Repository\CategoryRepository;
use App\Repository\CoursRepository;
use App\Repository\TrainerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Trainer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//#[Security("is_granted('ROLE_TRAINER')")]
#[Route('/dashboard/trainer')]
class DashboardTrainerController extends AbstractController
{

    #[Route('/', name: 'app_dashboard_trainer', methods: ['GET'])]
    public function index(CoursRepository $coursRepository, CategoryRepository $categoryRepository): Response
    {
//        dd($coursRepository->findCoursesByTrainer($this->getUser()->getId()));
//        dd($this->getUser()->getId());
//        dd($coursRepository->findNbrCoursesByTrainer());
        return $this->render('trainer/index.html.twig', [
//            'courses' => $coursRepository->findCoursesByTrainer($this->getUser()->getId())
            'courses' => $coursRepository->findNbrCoursesByTrainer(),


//            'courses' => $coursRepository->findAll(),
//            'categories' => $categoryRepository->findAll()

        ]);
    }

    #[Route('/course/new', name: 'coursNew',  methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $cours->setTrainer($this->getUser());
            $cours->setDate(new \DateTime('now'));
            $entityManager->persist($cours);
            $entityManager->flush();
            $this->addFlash('success', 'cours added');

//            return $this->json($cours);
            return $this->redirectToRoute('app_dashboard_trainer');
        }
        return $this->renderForm('trainer/course/new.html.twig', [
                'form' => $form,
                'cours' => $cours
        ]);
    }

    #[Route('/course/edit/{id}', name: 'courseEdit',  methods: ['GET', 'POST'])]
    public function edit(Cours $cours, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        dump($cours);
        if ($form->isSubmitted() && $form->isValid()) {
            $cours->setDate(new \DateTime('now'));
            $entityManager->persist($cours);
            $entityManager->flush();
            $this->addFlash('success', 'cours added');

//            return $this->json($cours);
            return $this->redirectToRoute('app_dashboard_trainer');
        }
        return $this->renderForm('trainer/course/edit.html.twig', [
                'form' => $form,
                'cours' => $cours
        ]);
    }
}
