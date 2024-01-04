<?php

namespace App\Controller;

use App\Entity\User;
// agency
use App\Entity\Agency;
use App\Entity\Company;
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
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dump($request);
            // dd($request);

            // CAS 1 - Quand On renseigne uniquement l'agence dans le formulaire :
                // Récupération de l'agence et sa société afin de flush les infos dans la BDD
            if (isset($request->get('user')['agencies'])) {
                        // Sous CAS 1,1 - Quand on sélectionne le role "ROLE_respAgenceProp" ou "ROLE_respAgenceLic", il faut laisser la possibilité de pouvoir sélectionner plusieurs agences
                        if (count($request->get('user')['agencies']) > 1) {
                            foreach ($request->get('user')['agencies'] as $agenceSelect) {
                                $agence = $entityManager->getRepository(Agency::class)->find($agenceSelect);
                                $companyId = $agence->getCompany()->getId();
                                $company = $agence->getCompany();
                                $user->setCompany($company);
                                $request->get('user')['company'] = $companyId;
                                $user->addAgency($agence);
                                $agence->addUser($user);
                            }
                        }
                    $agenceId = $request->get('user')['agencies'][0];
                    $agence = $entityManager->getRepository(Agency::class)->find($agenceId);
                    $companyId = $agence->getCompany()->getId();
                    $company = $agence->getCompany();
                    $user->setCompany($company);
                    $request->get('user')['company'] = $companyId;
                    $user->addAgency($agence);
                    $agence->addUser($user);
            }            
            // CAS 2 - Quand On renseigne uniquement la SOCIETE dans le formulaire :
                // Récupération de TOUTES LES AGENCES afin de flush les infos dans la BDD
            if (isset($request->get('user')['company'])) {
                // récupération COMPANY :
                $idCompany = $request->get('user')['company'];
                $company = $entityManager->getRepository(Company::class)->find($idCompany);
                $user->setCompany($company);
                // agence en lien avec la company :
                $agencyOfCompany = $entityManager->getRepository(Agency::class)->findBy([
                    'company' => $idCompany,
                ]);

                foreach ($agencyOfCompany as $company) {
                    $user->addAgency($company);
                };
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

            // get role from form
            $roles = $form->get('roles')->getData();

            // role is role_admin or role_superAdmin
            

            
            // if (in_array('ROLE_ADMIN', $roles) || in_array('ROLE_SUPER_ADMIN', $roles)) {
            //     $user->setRoles($roles);


            //     // get all agencies
               
            //     $agencies = $entityManager->getRepository(Agency::class)->findAll();

                
            //     foreach ($agencies as $agency) {
            //         $user->addAgency($agency);
            //         // agency addUser
            //         $agency->addUser($user);
            //         $entityManager->persist($agency);
            //     }
            
            
            // // Gestion des relations
            //     if (isset($request->get('user')['agences']) && count($request->get('user')['agences']) > 0) {
            //         $agenceId = $request->get('user')['agences'][0];
            //         dd($agenceId);
            // }

            // } 
            
            
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

        //ligne ci-dessous, reprend directement le rôle connu, pour initialiser la liste déroulante des RÔLES avec le bon rôle
        
        $rolesUser = $form->get('roles')->getData();
        $roleSetter = [];
        $roleReel = $rolesUser[0];
        $roleSetter[] = $roleReel;
        $form->get('roles')->setData($roleSetter);
        dump($roleReel);

        $form->handleRequest($request);

        // Avoir le rôle du user
        $roles = $form->get('roles')->getData()[0];

        if ($form->isSubmitted() && $form->isValid()) {
            // dd(($request));
            // agencies entity type
            $agencies = $request->get('user')['agencies'];

            foreach ($agencies as $agency) {
                $agence = $entityManager->getRepository(Agency::class)->find($agency);
                $user->addAgency($agence);
                        // agency addUser
                $agence->addUser($user);
                $entityManager->persist($agence);
            }


            // role is role_admin or role_superAdmin
            if ($roles == 'ROLE_ADMIN' || $roles == 'ROLE_SUPER_ADMIN') {
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
                    $agence = $entityManager->getRepository(Agency::class)->find($agency);
                    $user->removeAgency($agence);
                    $agence->removeUser($user);
                    $entityManager->persist($agence);
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
            'roleUser' => $roleReel,
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


    #[Route('/search/{data}', name: 'search_user')]
    public function search(UserRepository $userRepository, string $data): Response
    {
        // Faites votre logique de recherche ici
        $results = $userRepository->searchUser($data);

        return $this->json($results);
    }
}
