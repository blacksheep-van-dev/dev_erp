<?php

namespace App\Controller;

use App\Entity\BrandModel;
use App\Form\BrandModelType;
use App\Repository\BrandModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/brandmodel')]
class BrandModelController extends AbstractController
{
    #[Route('/', name: 'app_brand_model_index', methods: ['GET'])]
    public function index(BrandModelRepository $brandModelRepository): Response
    {
        return $this->render('brand_model/index.html.twig', [
            'brand_models' => $brandModelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_brand_model_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $brandModel = new BrandModel();
        $form = $this->createForm(BrandModelType::class, $brandModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($brandModel);
            $entityManager->flush();

            return $this->redirectToRoute('app_brand_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brand_model/new.html.twig', [
            'brand_model' => $brandModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brand_model_show', methods: ['GET'])]
    public function show(BrandModel $brandModel): Response
    {
        return $this->render('brand_model/show.html.twig', [
            'brand_model' => $brandModel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_brand_model_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BrandModel $brandModel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrandModelType::class, $brandModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_brand_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('brand_model/edit.html.twig', [
            'brand_model' => $brandModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_brand_model_delete', methods: ['POST'])]
    public function delete(Request $request, BrandModel $brandModel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brandModel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brandModel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_brand_model_index', [], Response::HTTP_SEE_OTHER);
    }
}
