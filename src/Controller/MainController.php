<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {

        // if user is logged in, redirect to home page
        if ($this->getUser()) {

            /**REDIRECT BASED ON ROLE */

            // GET USER ROLES
            $user = $this->getUser();

            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController',
            ]);

        }

        // else redirect to login page
        return $this->redirectToRoute('app_login');

    }
}
