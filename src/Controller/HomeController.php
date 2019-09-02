<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\EventsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends Controller {
    /**
     * @Route("/", name="home")
     */
    public function home(UserRepository $userRepo){
       
        //dd(substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", 60)), 0,60));
         $user = $userRepo->findLastest();
         //dd($user);
        return $this->render('home/index.html.twig',[
            'users' => $user
        ]
        );
    }
   
}
