<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use App\Repository\EventsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {
    /**
     * @Route("/{page<\d+>?1}", name="home")
     */
    public function index(UserRepository $userRepo ,$page, Request $request,PaginationService $pagination){
       
        //$request = $this->container->get('rehomquest');
       // $currentRouteName = $request->attributes->get('_controller');
       // dd($currentRouteName);
       //dump($request);
        //dd(substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", 60)), 0,60));
         $user = $userRepo->findLastest();
      
             $pagination->setEntityClass(User::class)
                        ->setPage($page)
                        ->setRoute('home');
        
          
        //dd($pagination->getData());
       // $expressionLanguage = new ExpressionLanguage();
       //$expressionLanguage->evaluate('"\\\\"')
        // dd( );
        return $this->render('home/index.html.twig',[
            'paginations' => $pagination,
            // 'users'=> $user
        ]);

    }
   
}
