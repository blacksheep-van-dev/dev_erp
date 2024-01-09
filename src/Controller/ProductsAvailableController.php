<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTime;
// use AsyncAws\Core\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ProductsAvailableController extends AbstractController
{
    #[Route('/products/available/', name: 'app_products_available')]
    public function __invoke(Request $request, ProductRepository $productRepository, )
    {
        $data = json_decode($request->getContent(), true);
        $productAvailable =[];

        $agency = $data['agency'];
        $dateStart = $data['dateStart'];
        $dateEnd = $data['dateEnd'];
    // dateStart et dateEnd doivent être renseigné de la sorte, par l'utilisateur :
        //     "dateStart":"2024-01-05",
        //     "dateEnd":"2024-01-11"

        // Récupération des produits n'ayant pas d'évènement de créé
        $productAvailable = array_merge($productAvailable, $productRepository->findProductWithoutEventCreated($agency));
        // Récupération des produits ayant un évènement de créé mais disponible au moins 1 jour sur les dates sélectionnées.
        $productAvailable = array_merge($productAvailable, $productRepository->findProductWithoutEvent($agency,$dateStart,$dateEnd));
        // Suppression des doublons potentiels
        $productAvailable = array_unique($productAvailable);


        if (count($productAvailable) < 1) {
            dd("Aucun résultat trouvé");
        }

        return $productAvailable;
    }
}
