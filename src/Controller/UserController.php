<?php

namespace App\Controller;

use App\Entity\User;
// agency
use App\Entity\Agency;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\FileUploader;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $passwordHasher, Agency $agency): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // upload picture profile
            $profileUrl = $form->get('picture')->getData();
            if ($profileUrl) {
                $profileUrlName = $fileUploader->upload($profileUrl);
                $user->setPicture($profileUrlName);
            }
            //pwd
            if ($form->get('password')->getData()) {
                // hash password
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            // get role from form
            $roles = $form->get('roles')->getData();

            // role is role_admin or role_superAdmin
            if (in_array('ROLE_ADMIN', $roles) || in_array('ROLE_SUPER_ADMIN', $roles)) {
                $user->setRoles($roles);


                // get all agencies
               
                $agencies = $entityManager->getRepository(Agency::class)->findAll();

                
                foreach ($agencies as $agency) {
                    $user->addAgency($agency);
                    // agency addUser
                    $agency->addUser($user);
                    $entityManager->persist($agency);
                }

            } 
            
            
            // else {
            //     // role is role_user
            //     $user->setRoles(['ROLE_USER']);
            // }



            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // agencies entity type

            $agencies = $form->get('agencies')->getData();
            foreach ($agencies as $agency) {
                $user->addAgency($agency);
                        // agency addUser
                $agency->addUser($user);
                $entityManager->persist($agency);
            }


            $roles = $form->get('roles')->getData();

            // role is role_admin or role_superAdmin
            if (in_array('ROLE_ADMIN', $roles) || in_array('ROLE_SUPER_ADMIN', $roles)) {
                $user->setRoles($roles);


                // get all agencies
               
                $agencies = $entityManager->getRepository(Agency::class)->findAll();

                
                foreach ($agencies as $agency) {
                    $user->addAgency($agency);
                    // agency addUser
                    $agency->addUser($user);
                    $entityManager->persist($agency);
                }

            } 

            else {
                // remove agencies from user
                foreach ($agencies as $agency) {
                  //remove user from agency
                    $user->removeAgency($agency);
                    $agency->removeUser($user);
                    $entityManager->persist($agency);
                }
            }


            // upload picture profile
            $profileUrl = $form->get('picture')->getData();
            if ($profileUrl) {
                $profileUrlName = $fileUploader->upload($profileUrl);
                $user->setPicture($profileUrlName);
            }
            //pwd
            if ($form->get('password')->getData()) {
                // hash password
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }








            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
