<?php

namespace App\Controller;
use App\Entity\User;
//use App\Form\AccountType;
//use App\Event\RegisterEvent;
//use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
//use App\Form\PasswordUpdateType;
use App\Service\MailerService;
use App\Repository\UserRepository;
//use App\Eventlistener\Registerlistener;
use App\Service\ValidationService;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
//use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends AbstractController
{

    private $mailer;
    private $token;

    public function __construct(UserPasswordEncoderInterface $encoder, ValidationService $token, MailerService $mailer)
    {
       
        $this->token = $token;
        $this->mailer = $mailer;
    }
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     * 
     * @Route("/login", name="account_login")
     * 
     * 
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        
     //   dd($this->getUser());
       // if($username) dump($username);
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    
    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, ValidationService $token) {

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
                           
        if($form->isSubmitted() && $form->isValid()) {
          
             $hash = $encoder->encodePassword($user, $user->getPassword());
             $user->setPassword($hash);
             $user->setToken($this->token->str_random());
             $manager->persist($user);
             $manager->flush();
             
             // Envoie de mail 
             $token = $user->getToken();
             $id= $user->getId();
             $email= $user->getEmail();
             //dd([$token,$id,$email]);
             $this->mailer->sendMail('ismanhassan18@gmail.com',$token, $email, $id);

             $this->addFlash('info', 'Votre inscription a été validée, vous aller recevoir un email de confirmation pour activer votre compte et pouvoir vous connecté');
           

            return $this->redirectToRoute('account_login');
            // return $this->render('account/registration.html.twig', [
            //     'form' => $form->createView()
            // ]);
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
   
    //     throw $this->createNotFoundException("No book with given isbn $isbn");
       
    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     *
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function myAccount() {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
    /**
     * Permet de confirmer le compte de l'utilisateur qui vient de s'inscrire
     *
     * @Route("/confirmation/{id}/{token}", name="account_confirm")
     * 
     * 
     * @return Response
     */
    public function Confirm(UserRepository $repo,int $id,string $token) {

       $user = $repo->findById($id);
        
       if($user[0]->getToken() == $token && $id ==$user[0]->getId())  {

           $this->addFlash(
                 'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

        //    return $this->render('account/confirm.html.twig', [
        //       'users' => $user
        //    ]);
           return $this->redirectToRoute('account_login');
        
       }
       else
       {
          return $this->redirectToRoute('account_register');
       }      

    }
    /**
     * Permet de se déconnecter
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout() : void {
        // .. rien !
    }

   
   
}
