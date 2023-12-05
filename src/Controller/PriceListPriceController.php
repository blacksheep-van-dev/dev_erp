<?php

namespace App\Controller;

use App\Entity\PriceListPrice;
use App\Form\PriceListPriceType;
use App\Repository\PriceListPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/price/list/price')]
class PriceListPriceController extends AbstractController
{
    #[Route('/', name: 'app_price_list_price_index', methods: ['GET'])]
    public function index(PriceListPriceRepository $priceListPriceRepository): Response
    {
        return $this->render('price_list_price/index.html.twig', [
            'price_list_prices' => $priceListPriceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_price_list_price_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $priceListPrice = new PriceListPrice();
        $form = $this->createForm(PriceListPriceType::class, $priceListPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($priceListPrice);
            $entityManager->flush();

            return $this->redirectToRoute('app_price_list_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('price_list_price/new.html.twig', [
            'price_list_price' => $priceListPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_price_list_price_show', methods: ['GET'])]
    public function show(PriceListPrice $priceListPrice): Response
    {
        return $this->render('price_list_price/show.html.twig', [
            'price_list_price' => $priceListPrice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_price_list_price_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PriceListPrice $priceListPrice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PriceListPriceType::class, $priceListPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_price_list_price_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('price_list_price/edit.html.twig', [
            'price_list_price' => $priceListPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_price_list_price_delete', methods: ['POST'])]
    public function delete(Request $request, PriceListPrice $priceListPrice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priceListPrice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($priceListPrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_price_list_price_index', [], Response::HTTP_SEE_OTHER);
    }
}
