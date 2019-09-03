<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\EventsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function home(UserRepository $userRepo ){
       
        
        //dd(substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", 60)), 0,60));
         $user = $userRepo->findLastest();
         $values = [
            10,
            20,
            '0',
            '123hello',
            'hello123'
        ];
        
       // $expressionLanguage = new ExpressionLanguage();
       //$expressionLanguage->evaluate('"\\\\"')
        // dd( );
        return $this->render('home/index.html.twig',[
            'users' => $user
        ]);

    }
   
}
