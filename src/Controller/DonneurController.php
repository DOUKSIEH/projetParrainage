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


/**
 * @Route("/donneur")
 */
class DonneurController extends AbstractController
{
    /**
     * @Route("/", name="donneur_index")
     */
    public function index(DonneurRepository $repo, Request $request)
    {
        $donneur = new Donneur();
        $form = $this->createForm(OneDonneurType::class, $donneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($donneur);
            // $entityManager->flush();
            $em = $this->getDoctrine()->getManager();
            $email=$donneur->getEmail();
            $repo = $em->getRepository(Donneur::class);
        
        $eMail = $repo-> findOneBy(array('email'=>$email));
      //dd($email); 
        
           $mail= $eMail->getEmail();
          // dd($mail); die;
        
        
        
      

            // $email = $this->getDoctrine()
            //              ->getManager()
            //              ->getRepository(Donneur::class)
            //              ->requestMail($email);
        if($email === $mail) {
            return $this->redirectToRoute('amount_donate_index');
        }
        else
        {
            return $this->redirectToRoute('donneur_new');
        }
            
        }
        

        // $repo = $em->getRepository(Donneur::class);
        // $email=$this->getEmail();
        // $eMail = $repo-> findAll();

        
       
        // $email = $this->getDoctrine()
        //                  ->getManager()
        //                  ->getRepository(Donneur::class)
        //                  ->requestMail($email);
        return $this->render('donneur/index.html.twig', [
            'controller_name' => 'DonneurController',
            'formOneDonneur' => $form->createView(),
            // 'email' => $email,
            // 'eMail' =>$eMail

        ]);
    }
     /**
     * @Route("/new", name="donneur_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('amount_donate_index');
        }

        return $this->render('donneur/new.html.twig', [
            'donneur' => $donneur,
            'formDonneur' => $form->createView(),
        ]);
    }

}
