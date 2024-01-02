<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Form\AgencyType;
use App\Repository\AgencyRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/agency')]
class AgencyController extends AbstractController
{
    #[Route('/', name: 'app_agency_index', methods: ['GET'])]
    public function index(AgencyRepository $agencyRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $agencies = [];

        if ($role == "ROLE_ADMIN") {
            $agencies = $agencyRepository->findAll();
        } else {
            $agencies = $user->getAgencies();
        }

        return $this->render('agency/index.html.twig', [
            'user' => $user,
            'agencies' => $agencies,
        ]);
    }

    #[Route('/new', name: 'app_agency_new', methods: ['GET', 'POST'])]
    public function new (Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $agency = new Agency();
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profileUrl = $form->get('picture')->getData();
            if ($profileUrl) {
                $profileUrlName = $fileUploader->upload($profileUrl);
                $agency->setPicture($profileUrlName);
            }

            // get adresses from form
            $addresses = $form->get('addresses')->getData();

            

            foreach ($addresses as $address) {
                $agency->addAddress($address);
                //address addAgency
                $address->addAgency($agency);
                $entityManager->persist($address);
            }

            $entityManager->persist($agency);
            $entityManager->flush();

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agency/new.html.twig', [
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agency_show', methods: ['GET'])]
    public function show(Agency $agency): Response
    {
        $company = $agency->getCompany();
        $products = $agency->getProducts();
        $options = $agency->getOptions();
        $bookings = $agency->getBookings();
        // dump($products);
        // dump($bookings);
        // dd($company);
        return $this->render('agency/show.html.twig', [
            'products' => $products,
            'company' => $company,
            'options' => $options,
            'bookings' => $bookings,
            'agency' => $agency,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agency_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agency $agency, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(AgencyType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profileUrl = $form->get('picture')->getData();
            if ($profileUrl) {
                $profileUrlName = $fileUploader->upload($profileUrl);
                $agency->setPicture($profileUrlName);
            }
         
            // manage agency collection of addresses
            // add new addresses to agency and remove deleted addresses from form
            $addresses = $form->get('addresses')->getData();
            foreach ($addresses as $address) {
                $agency->addAddress($address);
                $address->addAgency($agency);
                $entityManager->persist($address);
            }
            // remove deleted addresses from agency
            foreach ($agency->getAddresses() as $address) {
                // CONVERT TO ARRAY
                if (!in_array($address, $addresses->toArray())) {
                    $agency->removeAddress($address);
                    $address->removeAgency($agency);
                    $entityManager->persist($address);
                }
                
            }

              
            

            $entityManager->persist($agency);
            $entityManager->flush();
            
            

            return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agency/edit.html.twig', [
            'agency' => $agency,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agency_delete', methods: ['POST'])]
    public function delete(Request $request, Agency $agency, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $agency->getId(), $request->request->get('_token'))) {
            $entityManager->remove($agency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agency_index', [], Response::HTTP_SEE_OTHER);
    }
}
