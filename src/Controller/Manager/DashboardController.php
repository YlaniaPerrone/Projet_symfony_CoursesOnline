<?php

namespace App\Controller\Manager;

use App\Entity\Company;
use App\Entity\Trainer;
use App\Form\CompanyType;
use App\Form\TrainerType;
use App\Repository\CompanyRepository;
use App\Repository\TrainerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


//#[Security("is_granted('ROLE_MANAGER')")]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_manager_dashboard', methods: ['GET'])]
    public function index(TrainerRepository $trainerRepository): Response
    {

//        dd(  $trainerRepository->findTrainerByCompany(2));
//        dd($this->getUser());

            return $this->render('manager/index.html.twig', [
            'trainer' => $trainerRepository->findAll()
//        'trainer' => $trainerRepository->findTrainerByCompany($this->getUser()->getCompany()->getId()),
            ]);

    }

    #[Route('/dashboard/trainer/create', name: 'app_manager_create_trainer', methods: ['POST', 'GET'])]
    public function create( Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, CompanyRepository $companyRepository): Response
    {
        $trainer = new Trainer();

        $form = $this->createForm(TrainerType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company =  $companyRepository->findOneBy([
//                     'id' => $this->getUser()->getCompany()->getId()

            ]);
            $trainer->setCompany($company);
            $trainer->setPassword(
                    $userPasswordHasher->hashPassword(
                            $trainer,
                            $form->get('password')->getData()
                    )
            );
            $trainer->setRoles(['ROLE_TRAINER']);
            $trainer->setPassword($trainer->getPassword());
            $entityManager->persist($trainer);
            $entityManager->flush();

            return $this->redirectToRoute('app_manager_dashboard');
        }

        return $this->renderForm('manager/trainer/trainerCreate.html.twig', [
                'trainer' => $trainer,
                'registerTrainer' => $form,
        ]);

    }

    #[Route('/dashboard/trainer/edit/{id}', name: 'app_manager_edit_trainer', methods: ['POST', 'GET'])]
    public function edit(Trainer $trainer, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainerType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trainer->setPassword($trainer->getPassword());
            $entityManager->persist($trainer);
            $entityManager->flush();

            return $this->redirectToRoute('app_manager_dashboard');
        }

        return $this->renderForm('manager/trainer/trainerCreate.html.twig', [
                'trainer' => $trainer,
                'registerTrainer' => $form,
        ]);

    }
    //    #[Security("is_granted('ROLE_MANAGER')")]
//    #[Route('/manager/trainer/add', name: 'app_manager_add_trainer', methods: ['POST', 'GET'])]
//    public function create(TrainerRepository $trainerRepository, EntityManagerInterface $manager,  CompanyRepository $companyRepository, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
//    {
//
////        create random password (6,15) and convert to string
//        $password = ByteString::fromRandom(rand(6,15))->toString();
//        $data= ['firstname' => 'pani', 'name' => 'booder', 'email' => 'pani.booder@hotmail.com', 'password' => 'plkugh58dzd', 'role' => ['ROLE_TRAINER'], 'disable' => false];
//
//        $trainer = new Trainer();
//        $trainer->setFirstname($data['firstname']);
//        $trainer->setName($data['name']);
//        $trainer->setEmail($data['email']);
//        $trainer->setPassword(
//                    $userPasswordHasher->hashPassword(
//                            $trainer,
//                            $password
//                    )
//            );
//        $trainer->setRoles($data['role']);
//        $trainer->setIsDisable($data['disable']);
//
//        if ($this->getUser() && $this->isGranted('ROLE_MANAGER')  )
//        {
//            $company =  $companyRepository->findOneBy([
//                     'id' => $this->getUser()->getCompany()->getId()
//
//            ]);
////
//            $trainer->setCompany($company);
//
//
//        }
//        try {
//            $manager->persist($trainer);
//            $manager->flush();
//
//        }
//        catch (\Throwable $exception){
//            return $this->json([
//                    'code' => 500,
//                    'key' => 'server',
//                    'message' => 'email exist',
//                    'serverError' => $exception->getMessage()
//                    ], 500);
//        }
//        return $this->json([
//                'code' => 200,
//                'teacher' => $trainerRepository->findTrainerById($trainer->getId())
//        ]);
//    }


}
