<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingItem;
use App\Entity\Product;
use App\Entity\ProductCategory;
//agency
use App\Entity\Agency;
use App\Form\Booking1Type;
use App\Repository\BookingRepository;
use App\Entity\ProductEvent;
use App\Form\ProductEventType;
use App\Repository\ProductEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository,ProductEventRepository $productEventRepository): Response
    {

        // $productEvents = $productEventRepository->findAll();
        // $data = [];

        // foreach ($productEvents as $productEvent) {
        //     $data[] = [
        //         'id' => $productEvent->getId(),
        //         'type' => $productEvent->getType(),
        //         'DateBegin' => $productEvent->getDateBegin(),
        //         'DateEnd' => $productEvent->getDateEnd(),
        //         // 'name' => $productEvent->getName(),
        //         // 'description' => $productEvent->getDescription(),
        //         // 'price' => $productEvent->getPrice(),
        //         // 'quantity' => $productEvent->getQuantity(),
        //         // 'image' => $productEvent->getImage(),
        //         // 'createdAt' => $productEvent->getCreatedAt(),
        //         // 'updatedAt' => $productEvent->getUpdatedAt(),
        //     ];
        // }



        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
            'events' => $productEventRepository->findAll()
        ]);
    }
    

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        // return agency list 
        $agency = $entityManager->getRepository(Agency::class)->findAll();

        
        // return product categories list of a specific agency

        if ($request->getMethod() == 'POST') {

            // get date begin & end

            $dateRange = $request->request->get('daterange');
            $dates = explode(" - ", $dateRange);

            // get start and end dates
            $start = $dates[0];
    
            $end = $dates[1];

            // convert 29/10/2023 05:36:50 to 2023-10-29 05:36:50 
            $start = str_replace('/', '-', $start);
            $end = str_replace('/', '-', $end);

            $start = date('Y-m-d H:i', strtotime($start));
            $end = date('Y-m-d H:i', strtotime($end));


            $agencyId = $request->request->get('agency');
            $agency = $entityManager->getRepository(Agency::class)->find($agencyId);

        
            //$products = $entityManager->getRepository(Product::class)->findBy(['agency' => $agency]);

            $products = $entityManager->getRepository(Product::class)->findProductWithoutEvent(
                $agency,
                $start,
                $end
            );

            // dd($products);

      
            return $this->render('booking/_products.html.twig', [
                'products' => $products,
            ]);


           


        }


        return $this->render('booking/new.html.twig', [
            // 'booking' => $booking,
            // 'form' => $form,
            'agency' => $agency,
        ]);
    }


    // route create booking
    #[Route('/create', name: 'app_booking_create', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking(); // Collection de bookingItems null

        $bookingItem = new BookingItem(); // => un enregistrement par produit

        // return json response
        $response = new Response();
        $responseData = [
            'status' => 'ok',
            'message' => 'booking created successfully!',
        ];
        $response->headers->set('Content-Type', 'application/json');// 

        // send response
        $response->setContent(json_encode($responseData));

        return $response;

    }


    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Booking1Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
