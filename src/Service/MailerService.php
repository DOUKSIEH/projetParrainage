<?php

namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService extends AbstractController
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    /**
     * @param $token
     * @param $username
     * @param $template
     * @param $to
     */
    public function sendMail($from,$token, $email, $username)
    {
        $message = (new \Swift_Message('Mail de confirmation'))
                  ->setFrom($from)
                  ->setTo($email)
                 ->setBody('<a href=http://127.0.0.1:8000/confirmation/'.$username.'/'.$token.'>Afin de valider votre compte merci de cliquer sur ce lien\n\n http://127.0.0.1:8000/confirmation/'.$username.'/'.$token.'</a>',
                'text/html'
                    )
        ;
       // dd($message);
     $this->mailer->send($message);
    }
}

