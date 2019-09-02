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
<<<<<<< HEAD
    public function home(UserRepository $userRepo){
       
        //dd(substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", 60)), 0,60));
         $user = $userRepo->findLastest();
         //dd($user);
        return $this->render('home/index.html.twig',[
            'users' => $user
        ]
=======
    public function index()
    {
       // dd("coucu");
        // $event = $eventRepo->findLastest();
        // $user = $userRepo->findLastest();
        // dump( $userRepo->findLastest());
       // die();
        return $this->render(
            'home/index.html.twig'
>>>>>>> d6704dd076cc28f8f67df46a5bfde1a2f4b98490
        );
    }
   
}
