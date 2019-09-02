<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Form\ParrainageType;
use App\Repository\FilleulRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParrainageController extends AbstractController
{
    /**
     * @Route("/parrainage", name="parrainage")
     */
    public function index(Request $request,ObjectManager $manager, FilleulRepository $filleulRepository)
    {

        $filleulsPays = $filleulRepository->findCountriesOfGodsons();

        $form = $this->createForm(ParrainageType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

//            $manager->persist($user);
//            $manager->flush();

            $this->addFlash(
                'success',
                "Votre choix a bien été pris en compte !"
            );
            return $this->redirectToRoute('parrainage_filleuls');
        }


        return $this->render('parrainage/index.html.twig', [
            'controller_name' => 'ParrainageController',
            'pays_filleuls' => $filleulsPays,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/parrainage/filleuls", name="parrainage_filleuls")
     */
    public function getAllFilleuls(FilleulRepository $filleulRepository) : Response
    {
        return $this->render('parrainage/liste.html.twig', [
            'liste_filleuls' => $filleulRepository->findAll(),
        ]);
    }



}
