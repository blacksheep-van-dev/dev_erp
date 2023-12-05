<?php

namespace App\Controller;

use App\Entity\Insurance;
use App\Form\InsuranceType;
use App\Repository\InsuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/insurance')]
class InsuranceController extends AbstractController
{
    #[Route('/', name: 'app_insurance_index', methods: ['GET'])]
    public function index(InsuranceRepository $insuranceRepository): Response
    {
        return $this->render('insurance/index.html.twig', [
            'insurances' => $insuranceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_insurance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $insurance = new Insurance();
        $form = $this->createForm(InsuranceType::class, $insurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($insurance);
            $entityManager->flush();

            return $this->redirectToRoute('app_insurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('insurance/new.html.twig', [
            'insurance' => $insurance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_insurance_show', methods: ['GET'])]
    public function show(Insurance $insurance): Response
    {
        return $this->render('insurance/show.html.twig', [
            'insurance' => $insurance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_insurance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Insurance $insurance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InsuranceType::class, $insurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_insurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('insurance/edit.html.twig', [
            'insurance' => $insurance,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_insurance_delete', methods: ['POST'])]
    public function delete(Request $request, Insurance $insurance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$insurance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($insurance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_insurance_index', [], Response::HTTP_SEE_OTHER);
    }
}
