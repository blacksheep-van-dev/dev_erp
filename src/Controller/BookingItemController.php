<?php

namespace App\Controller;

use App\Entity\BookingItem;
use App\Form\BookingItemType;
use App\Repository\BookingItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booking/item')]
class BookingItemController extends AbstractController
{
    #[Route('/', name: 'app_booking_item_index', methods: ['GET'])]
    public function index(BookingItemRepository $bookingItemRepository): Response
    {
        return $this->render('booking_item/index.html.twig', [
            'booking_items' => $bookingItemRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booking_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookingItem = new BookingItem();
        $form = $this->createForm(BookingItemType::class, $bookingItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookingItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking_item/new.html.twig', [
            'booking_item' => $bookingItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_item_show', methods: ['GET'])]
    public function show(BookingItem $bookingItem): Response
    {
        return $this->render('booking_item/show.html.twig', [
            'booking_item' => $bookingItem,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookingItem $bookingItem, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingItemType::class, $bookingItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking_item/edit.html.twig', [
            'booking_item' => $bookingItem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_item_delete', methods: ['POST'])]
    public function delete(Request $request, BookingItem $bookingItem, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookingItem->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bookingItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
