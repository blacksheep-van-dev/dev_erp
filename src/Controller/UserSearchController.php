<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use PhpParser\Node\Expr\Cast\String_;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[AsController]
class UserSearchController extends AbstractController
{
    
    private $userRepository;
        
    #[Route('/user/search/{data}', name: 'search_user')]
    public function __construct(UserRepository $userRepository)
    {
        // dd('Route personnalisée SWAN, OK');
        $this->userRepository = $userRepository;
    }


    public function __invoke(string $data, Request $request)
    {
        $results = $this->userRepository->findBySearch($data);
        // $datas = $request->get('data');
        $datas = $request->query->all();
        dump($datas);


        // $firstName = $datas->getFirstName();
        // dd($firstName);
    }
}
