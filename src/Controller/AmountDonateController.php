<?php

namespace App\Controller;

use App\Entity\AmountDonate;
use App\Entity\Donneur;
use App\Form\AmountDonateType;
use App\Repository\AmountDonateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RadioAmountType;


/**
 * @Route("/amount/donate")
 */
class AmountDonateController extends AbstractController
{
    /**
     * @Route("/", name="amount_donate_index", methods={"GET"})
     */
    public function index(AmountDonateRepository $amountDonateRepository): Response
    {
        return $this->render('amount_donate/index.html.twig', [
            'amount_donate' => $amountDonateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="amount_donate_new", methods={"GET","POST"})
     */
    public function new(Request $request, Donneur $donneur): Response
    {
        $amountDonate = new AmountDonate();
        $form = $this->createForm(AmountDonateType::class, $amountDonate);
        $form->handleRequest($request);
        // $formRadio = $this->createForm(RadioAmountType::class);
        // $formRadio->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
           
            $amountDonate->setIdDonneur($donneur);
            $amountDonate->setDonnationDate(new \DateTime());
           
            $entityManager = $this->getDoctrine()->getManager();
           
            $entityManager->persist($amountDonate);
            $entityManager->flush();
            $this->addFlash('success', 'Paiement validé ! Vous avez un coeur en or !');
            return $this->redirectToRoute('home');

        }

        return $this->render('amount_donate/new.html.twig', [
            'amount_donate' => $amountDonate,
            'form' => $form->createView(),
           
           // 'email'=>$email
        ]);
    }

    /**
     * @Route("/{id}", name="amount_donate_show", methods={"GET"})
     */
    public function show(AmountDonate $amountDonate): Response
    {
        return $this->render('amount_donate/show.html.twig', [
            'amount_donate' => $amountDonate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="amount_donate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AmountDonate $amountDonate): Response
    {
        $form = $this->createForm(AmountDonateType::class, $amountDonate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('amount_donate_index');
        }

        return $this->render('amount_donate/edit.html.twig', [
            'amount_donate' => $amountDonate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="amount_donate_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AmountDonate $amountDonate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$amountDonate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($amountDonate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('amount_donate_index');
    }
}
