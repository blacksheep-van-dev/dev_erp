<?php

namespace App\Controller;

use App\Entity\ProductEvent;
use App\Form\ProductEventType;
use App\Repository\ProductEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/productevent')]
class ProductEventController extends AbstractController
{
    #[Route('/', name: 'app_product_event_index', methods: ['GET'])]
    public function index(ProductEventRepository $productEventRepository): Response
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $productEvent = [];

        if ($role == "ROLE_ADMIN") {
            $product_events = $productEventRepository->findAll();
        } else {
            $agences = $user->getAgencies();
            
            foreach ($agences as $agence) {
                $productAgency = $agence->getProducts();

                foreach ($productAgency as $product) {
                    $productEventProduct = $product->getProductEvents()->toArray();
                    $productEvent = array_merge($productEvent, $productEventProduct);
                }
            }
        }


        return $this->render('product_event/index.html.twig', [
            'product_events' => $productEvent,
            // 'product_events' => $productEventRepository->findAll(),
        ]);
    }


    // route to return list of products events in json format
    #[Route('/list', name: 'app_product_event_list', methods: ['GET'])]
    public function list(ProductEventRepository $productEventRepository): Response
    {
        $productEvents = $productEventRepository->findAll();
        $data = [];
        

        foreach ($productEvents as $productEvent) {
            $data[] = [
                'id' => $productEvent->getId(),
                'type' => $productEvent->getType(),
                'DateBegin' => $productEvent->getDateBegin(),
                'DateEnd' => $productEvent->getDateEnd(),
                // 'name' => $productEvent->getName(),
                // 'description' => $productEvent->getDescription(),
                // 'price' => $productEvent->getPrice(),
                // 'quantity' => $productEvent->getQuantity(),
                // 'image' => $productEvent->getImage(),
                // 'createdAt' => $productEvent->getCreatedAt(),
                // 'updatedAt' => $productEvent->getUpdatedAt(),
            ];
        }

        // return json response
        $response = new Response();
        $responseData = [
            'status' => 'ok',
            'message' => 'products events list!',
            'data' => $data,
        ];
        $response->headers->set('Content-Type', 'application/json');

        // send response
        $response->setContent(json_encode($responseData));

        return $response;
    }



    #[Route('/new', name: 'app_product_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user = $security->getUser();
        $agencies = $user->getAgencies();
        $productTab = [];

        foreach ($agencies as $agencie) {
            //push les produits dans le tableau de produits initialement vide
            $productAgencie = $agencie->getProducts()->toArray();
            $productTab = array_merge($productTab, $productAgencie);
        }

        $productEvent = new ProductEvent();
        $form = $this->createForm(ProductEventType::class, $productEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($productEvent);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_event/new.html.twig', [
            'product_event' => $productEvent,
            'form' => $form,
            'products' => $productTab,
        ]);
    }

    #[Route('/{id}', name: 'app_product_event_show', methods: ['GET'])]
    public function show(ProductEvent $productEvent): Response
    {
        return $this->render('product_event/show.html.twig', [
            'product_event' => $productEvent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProductEvent $productEvent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductEventType::class, $productEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_event/edit.html.twig', [
            'product_event' => $productEvent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_event_delete', methods: ['POST'])]
    public function delete(Request $request, ProductEvent $productEvent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productEvent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($productEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_event_index', [], Response::HTTP_SEE_OTHER);
    }



}
