<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\DonneurType;
use App\Form\OneDonneurType;
use App\Entity\Donneur;
use App\Repository\DonneurRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestJsonController extends AbstractController
{
    /**
     * @Route("/test/json", name="test_json")
     */
    public function index(DonneurRepository $repo, Request $request)
    {
        $donneur = new Donneur();
        
        $form = $this->createForm(OneDonneurType::class, $donneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $em = $this->getDoctrine()->getManager();
            $email = $donneur->getEmail();
           
            $repo = $em->getRepository(Donneur::class);

            $existingDonneur = $repo->findOneBy(array('email' => $email));
 
            if ($existingDonneur instanceof Donneur) 
            {
                $existingDonneur = $repo->findBy(['email' => $email]);
               
                //dd($existingDonneur);

                $filter_mail= array_map(function($item){
                    return ['id'=>$item->getId(),
                    'mail'=>$item->getEmail(),
                    'href'=>$this->generateUrl('amount_donate_new', ['id' => $item->getId()])];}, $existingDonneur);
                  //  dd($filter_mail); 
               return new JsonResponse($filter_mail);
                
                    //return $this->redirectToRoute('amount_donate_new', ['id' => $existingDonneur->getId()]);
                    // return $this->render('donneur/index.html.twig', [
                    //     'controller_name' => 'DonneurController',
                    // ]);

            } else {
                return $this->redirectToRoute('donneur_new');
            }
        }
        return $this->render('donneur/index.html.twig', [
            'controller_name' => 'DonneurController',
            'formOneDonneur' => $form->createView(),

        ]);
    }
    /**
     * @Route("/test/json", name="test_json_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $donneur = new Donneur();
        $form = $this->createForm(DonneurType::class, $donneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donneur);
            $entityManager->flush();

            return $this->redirectToRoute('donneur_index');
        }

        return $this->render('donneur/new.html.twig', [
            'donneur' => $donneur,
            'formDonneur' => $form->createView(),
        ]);
    }

    
        /**
     * @Route("/test/profile/json", name="display_json_user_form", methods={"GET"})
     */
    public function userProfile(Request $request, DonneurRepository $repo): Response
    {
        // var_dump($request->query->get('email')); die;

        /* TODO : Teser si le mailexiste dQNS L BASE */

        $donneur = new Donneur();

        $donneur->setEmail($request->query->get('email'));
        $form = $this->createForm(DonneurType::class, $donneur);
        $form->handleRequest($request);

        $html = $this->render('donneur/newJson.html.twig', [
            'formDonneur' => $form->createView(),
        ]);

        var_dump($html->getContent());

        return new JsonResponse(['form' => $html->getContent()]);
    }

}
