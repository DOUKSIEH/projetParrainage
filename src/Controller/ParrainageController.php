<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Entity\User;
use App\Form\PaiementparrainType;
use App\Form\ParrainageType;
use App\Repository\FilleulRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function mysql_xdevapi\getSession;

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
     * Permet d'effectuer le paiement mensuel
     *
     * @Route("/parrainage/paiement_mensuel_filleul", name="paiement_mensuel_filleul", methods={ "POST" })
     *
     * @return Response
     */
    public function paiementMensuel(Request $request, ObjectManager $manager, FilleulRepository $filleulRepository) {


        if($request->isMethod('post')) {

            $idFilleul = $request->request->get("idFilleul");
            $filleul = $filleulRepository->findOneFilleulById($idFilleul);

            $user = $this->getUser();
            $filleul->setParrain($user);
            $manager->persist($filleul);
            $manager->flush();



            //TODO ajouter à parrain valeure mensuelle : M de paiement
            // lier filleul à parrain
            // de fait, récupérer idUser

           // dd($filleul);
        }


        return $this->render('parrainage/tabDeParrainage.html.twig', [
            'filleul' => $filleul
        ]);
    }

    /**
     * Permet d'effectuer le paiement annuel
     *
     * @Route("/parrainage/paiement_annuel_filleul", name="paiement_annuel_filleul", methods={ "POST" })
     *
     * @return Response
     */
    public function paiementAnnuel(Request $request, ObjectManager $manager, FilleulRepository $filleulRepository) {


        if($request->isMethod('post')) {

            $idFilleul = $request->request->get("idFilleul");
            $filleul = $filleulRepository->findOneFilleulById($idFilleul);

            $user = $this->getUser();
            $filleul->setParrain($user);
            $manager->persist($filleul);
            $manager->flush();

            //TODO ajouter à parrain valeure annuelle : A de paiement
            // lier filleul à parrain
            // de fait, récupérer idUser

            // dd($filleul);
        }

        return $this->render('parrainage/tabDeParrainage.html.twig', [
            'filleul' => $filleul
        ]);
    }


}
