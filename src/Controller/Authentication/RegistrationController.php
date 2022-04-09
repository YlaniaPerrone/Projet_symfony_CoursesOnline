<?php

namespace App\Controller\Authentication;

use App\Entity\Trainer;
use App\Entity\Company;
use App\Entity\User;
use App\Form\CompanyType;
use App\Form\RegistrationFormateurFormType;
use App\Form\ManagerType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register/company', name: 'register_company', methods: ['POST', 'GET'])]
    public function registerCompany(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $manager = new Trainer();
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            casting
            $formCompany = (object)$request->get('company')['trainers'];

            $manager->setFirstname($formCompany->firstname);
            $manager->setName($formCompany->name);
            $manager->setEmail($formCompany->email);
            $manager->setRoles(['ROLE_MANAGER']);


            if ($formCompany->password['first'] === $formCompany->password['second']) {
                $manager->setPassword(
                     $userPasswordHasher->hashPassword(
                            $manager,
    //                      recup le premier
                            $formCompany->password['first']
                    )
                );

            }
            dump($formCompany);

            $company->addTrainer($manager);

//            return $this->json([$manager]);
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_trainer_login');
        }

        return $this->render('Authentication/registration/registerCompany.html.twig', [
                'registerCompany' => $form->createView(),
        ]);
    }

    #[Route('/register', name: 'register_user', methods: ['GET', 'POST'])]
    public function registerUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('password')->getData()
                    )
            );

            $user->setRoles(['ROLE_USER']);


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('Authentication/registration/registerUser.html.twig', [
                'registrationClient' => $form->createView(),
        ]);

    }

//    #[Route('/register/trainer', name: 'register_trainer', methods: ['GET', 'POST'])]
//    public function registerTrainer(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
//    {
//        $trainer = new Trainer();
//        $form = $this->createForm(TrainerType::class, $trainer);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $trainer->setPassword(
//                    $userPasswordHasher->hashPassword(
//                            $trainer,
//                            $form->get('password')->getData()
//                    )
//            );
//
//            $trainer->setRoles(['ROLE_TRAINER']);
//
//
//            $entityManager->persist($trainer);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_login');
//        }
//
//        return $this->render('Authentication/registration/registerTrainer.html.twig', [
//                'registrationTrainer' => $form->createView(),
//        ]);
//
//    }
}
