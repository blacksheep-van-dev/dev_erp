<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//user
use App\Entity\User;
//user repo
use App\Repository\UserRepository;

use Doctrine\Persistence\ManagerRegistry;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(ManagerRegistry $doctrine): Response
    {

        // get users with role customer
        $users = $doctrine->getRepository(User::class)->findByRole('ROLE_CUSTOMER');

        
        return $this->render('customer/index.html.twig', [
        
            'users' => $users,
        ]);
    }
}
