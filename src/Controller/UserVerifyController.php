<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserVerifyController extends AbstractController
{
    #[Route('/user/verify', name: 'app_user_verify')]
    public function __invoke(User $user)
    {
        $user->setIsVerified(true);

        return $user;
    }
}
