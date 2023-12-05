<?php

namespace App\Controller;

use App\Entity\Agency;
// agencies
use App\Entity\Booking;
use App\Entity\User;
// products
use App\Entity\Product;
//ProductEvent
use App\Entity\ProductEvent;
// users
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

// route create

    #[Route('/create', name: 'app_booking_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        // get list of agency entityManager
        $agencies = $entityManager->getRepository(Agency::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();

        // return view
        return $this->render('booking/create.html.twig', [
            'agencies' => $agencies,
            'users' => $users,

        ]);

    }

// findProductWithoutEvent
    #[Route('/findProductWithoutEvent', name: 'app_booking_findProductWithoutEvent', methods: ['POST'])]
    public function findProductWithoutEvent(Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($request->getMethod() === "POST") {
            // Décodez les données JSON en tableau associatif
            $arrayData = json_decode($request->getContent(), true);

            // dd($arrayData);

            // get data
            $agStart = $arrayData['agenceDepart'];
            $agReturn = $arrayData['agenceRetour'];
            $start = $arrayData['dateDepart'];
            $end = $arrayData['dateRetour'];

            $start = date('Y-m-d H:i:s', strtotime($start));
            $end = date('Y-m-d H:i:s', strtotime($end));

            // Agence
          
            $agency = $entityManager->getRepository(Agency::class)->find($agStart);

           

            $products = $entityManager->getRepository(Product::class)->findProductWithoutEvent(
                $agency,
                $start,
                $end
            );

           // products findProductByCategory
            // $products = $entityManager->getRepository(Product::class)->findProductByCategory(
            //     $agency
            // );

            // dd($products);
            

            // return array
            $array = [];
            foreach ($products as $product) {


                // // chcek if product has product event for this agency
                // $productEvent = $entityManager->getRepository(ProductEvent::class)->findProductEventByProductAndAgency(
                //     $product,
                //     $agency,
                //     $start,
                //     $end
                // );

                // dd($productEvent);






                $array[] = [
                    'id' => $product->getId(),
                    'label' => $product->getLabel(),
                    'category' => $product->getProductCategory()->getLabel(),
                    'model' => $product->getModel()->getLabel(),
                    // 'agency' => $product->getAgency()->getName(),
                    // options stock
                    // 'optionsStock' => $product->getOptionStocks(),
                ];
            }


           
            

      
            
        }

        // return json response
        return $this->json([
            'message' => 'success',
            'data' => $array,
        ]);

    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new (Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
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
        $form = $this->createForm(BookingType::class, $booking);
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
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
