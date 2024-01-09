<?php

namespace App\Controller;

use App\Entity\Agency;
// agencies
use App\Entity\Booking;
// bookingItem
use App\Entity\Product;
//ProductEvent
use App\Entity\ProductEvent;
// users
use App\Form\BookingType;
use App\Repository\AgencyRepository;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/booking')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository, Security $security): Response
    {
        $bookings = [];
        $user = $security->getUser();
        $agences = $user->getAgencies()->toArray();
            foreach ($agences as $agence) {
                $bookingsOfAgency= $agence->getBookings()->toArray();
                $bookings = array_merge($bookings, $bookingsOfAgency);
            }

        return $this->render('booking/index.html.twig', [
            // 'bookings' => $bookingRepository->findAll(),
            'bookings' => $bookings,
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

            $start = date('Y-m-d H:i', strtotime($start));
            $end = date('Y-m-d H:i', strtotime($end));

            // Agence
          
            $agency = $entityManager->getRepository(Agency::class)->find($agStart);

     
            $bookingItem = $agency->getbookingItem();

       
         
            // return array
            $array = [];
            foreach ($bookingItem as $product) {

                // check if a product event is already created for this product id 
                $productEvent = $entityManager->getRepository(ProductEvent::class)->findOneBy([
                    'product' => $product->getId(),
                    // dates convert to DateTimeImmutable
                    'dateBegin' => new \DateTimeImmutable($start),
                    'dateEnd' => new \DateTimeImmutable($end),
                ]);

                // if no product event
                if (!$productEvent) {
                    // add product to array
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


            
        }

        // return json response
        return $this->json([
            'message' => 'success',
            'data' => $array,
        ]);

    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new (UserRepository $userRepository,AgencyRepository $agencyRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        $agency = $this->getUser()->getAgencies()->toArray();

        if ($form->isSubmitted() && $form->isValid()) {
            $nombreAleatoire = rand(66, 9999);
            $agenceSource = $booking->getBookingAgencySource()->getName();
            $customer = $booking->getUser()->getLastName();

            // Gestion de la référence booking
            $booking->setReference(("BS_".$agenceSource."_".$customer."_".$nombreAleatoire));

           // Gestion product (si agence départ est différent de agence d'arrivée ... alors nouvelle agence du product = agence d'arrivée)
           $agencySource = $booking->getBookingAgencySource();
           $agencyTarget = $booking->getBookingAgencyTarget();
           $bookingItem = $booking->getBookingItems();
            if ($agencySource != $agencyTarget) {
                foreach ($bookingItem as $product) {
                    $bookingItemelected = $product->getProduct();
                    $bookingItemelected->setAgency($agencyTarget);
                   }
           }

           // Gestion des Dates
           $dateBegin = $request->get('booking')['dateBegin'];
           $dateEnd = $request->get('booking')['dateEnd'];

                    if (empty($dateEnd['year'])||empty($dateBegin['year'])||empty($dateEnd['month'])||empty($dateBegin['month'])||empty($dateEnd['day'])||empty($dateBegin['day'])) {
                        error_log("IL faut impérativement renseigner des dates de début et de fin");
                        echo("IL faut impérativement renseigner des dates de début et de fin");
                    }
                    if ($dateEnd['year'] < $dateBegin['year']) {
                        error_log("L'année de début d'un booking, ne peut être supérieur à l'année de fin d'un booking");
                        echo("L'année de début d'un booking, ne peut être supérieur à l'année de fin d'un booking");
                    } elseif ($dateEnd['year'] == $dateBegin['year']) {
                            if ($dateEnd['month'] < $dateBegin['month']) {
                                error_log("Le mois de début d'un booking, ne peut être supérieur au mois de fin d'un booking");
                                echo("Le mois de début d'un booking, ne peut être supérieur au mois de fin d'un booking");
                            } elseif ($dateEnd['month'] == $dateBegin['month']) {
                                if ($dateEnd['day'] < $dateBegin['day']) {
                                    error_log("Le jour de début d'un booking, ne peut être supérieur au jour de fin d'un booking");
                                    echo("Le jour de début d'un booking, ne peut être supérieur au jour de fin d'un booking");    
                                }
                            }
                    }

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/new.html.twig', [
            'agencies' => $agency,
            'allAgencies' => $agencyRepository->findAll(),
            'allUser' => $userRepository->findAll(),
            'booking' => $booking,
            'form' => $form,
        ]);
    }




    #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    public function show(Booking $booking): Response
    {
        $bookingItems = $booking->getBookingItems()->toArray();
        $products = [];
        $activities = [];
        $insurances = [];

        foreach ($bookingItems as $bookingItem) {
            $products[] = $bookingItem->getProduct();
            $activities[] = $bookingItem->getActivities();
            $insurances[] = $bookingItem->getInsurance();
        }

        return $this->render('booking/show.html.twig', [
            'bookingItems' => $bookingItems,
            'booking' => $booking,
            'products' => $products,
            'insurances' => $insurances,
            'activities' => $activities,
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
