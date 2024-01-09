<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//json response
use Symfony\Component\HttpFoundation\JsonResponse;
// use all entities
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Address;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Meilisearch\Bundle\SearchService;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['POST'])]
    // function to rerieve data send in post method
    public function index(SearchService $searchService, Request $request, ManagerRegistry $doctrine): Response
    {
        // decode json
        $data = json_decode($request->getContent())?? '';

        $em = $doctrine->getManager();

        // meilisearch multi search
        $users = $searchService->search($em, User::class, $data);
        $companies = $searchService->search($em, Company::class, $data);
        $addresses = $searchService->search($em, Address::class, $data);

        
    }
    
}
