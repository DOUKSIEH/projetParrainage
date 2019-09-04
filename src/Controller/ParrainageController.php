<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Form\PaiementparrainType;
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

        return $this->render('parrainage/index.html.twig', [
            'controller_name' => 'ParrainageController',
            'pays_filleuls' => $filleulsPays,

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

    /**
     * @Route("/parrainage/filleul_attribué", name="parrainage_filleul_attribué", methods={ "POST" })
     *
     */
    public function getFilleulRecherche(FilleulRepository $filleulRepository, Request $request) : Response
    {
        if($request->isMethod('post')){

            $pays = $request->request->get("pays");
            $age = $request->request->get("age");
            $sexe = $request->request->get("sexe");

            $filleulsTableau = $filleulRepository->findRandomGodsons($age, $sexe, $pays);

            if(empty($filleulsTableau)) {
                $this->addFlash("warning" ,"Aucun enfant pour la requête effectuée");
               return  $this->redirectToRoute('parrainage');
            }
            $randIndex = array_rand($filleulsTableau);
            $filleulAttribue = $filleulsTableau[$randIndex];
            if ($filleulAttribue->getGenre()=="male") {
                $filleulAttribue->setGenre("Homme");
            }
            else {
                $filleulAttribue->setGenre("Femme");
            }
        }
        return $this->render('parrainage/filleulAttribué.html.twig', [
            'filleul_attributed' => $filleulAttribue,
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/parrainage/paiementfilleul", name="paiement_filleul")
     *
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager) {

        $form = $this->createForm(PaiementparrainType::class);
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid()) {
//
//            $hash = $encoder->encodePassword($user, $user->getPassword());
//
//            $user->setPassword($hash);
//            $manager->persist($user);
//            $manager->flush();
//
//            $this->addFlash(
//                'success',
//                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
//            );
//            return $this->redirectToRoute('account_login');
//        }
        return $this->render('parrainage/tabDeParrainage.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
