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

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $em = $this->getDoctrine()->getManager();
            $email = $donneur->getEmail();
           
            $repo = $em->getRepository(Donneur::class);

            $existingDonneur = $repo->findOneBy(array('email' => $email));
 
            if ($existingDonneur instanceof Donneur) 
            {
               
                    return $this->redirectToRoute('amount_donate_new', ['id' => $existingDonneur->getId()]);
                    return $this->render('donneur/index.html.twig', [
                        'controller_name' => 'DonneurController',
                    ]);

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

            return $this->redirectToRoute('donneur_index');
        }

        return $this->render('donneur/new.html.twig', [
            'donneur' => $donneur,
            'formDonneur' => $form->createView(),
        ]);
    }
}
