<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('prenom', TextType::class, $this->getConfiguration("Prénom", "Votre prénom ..."))
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille ..."))
            ->add('adresse', TextareaType::class, $this->getConfiguration("Adresse","Votre adresse..."))
            ->add('ville', TextType::class, $this->getConfiguration("Ville", "Votre Ville ..."))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email"))
            ->add('password', PasswordType::class, $this->getConfiguration("Mot de passe", "Choisissez un bon mot de passe !"))
            ->add('telephone', TextType::class, $this->getConfiguration("Telephone", "Votre numéro de telephone ..."))
            ->add('image', UrlType::class, $this->getConfiguration("Photo de profil", "URL de votre avatar ..."))
       ; 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
