<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ValidationService extends AbstractController {





    public  function str_random(){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, 50)), 0, 50);
    }




    
}