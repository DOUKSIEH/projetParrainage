<?php

namespace App\Form;

use App\Entity\AmountDonate;
//use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints\NotBlank;


class AmountDonateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'Somme',
                IntegerType::class,
                [
                    'label' => 'Quelle somme souhaitez-vous donner ?',
                    'invalid_message' => '--- Entrez le montant uniquement, ce montant est en Euros ---',
                    'constraints' => [new NotBlank()]
                ]
            )
            ->add(
                'Frequency',
                ChoiceType::class,
                [
                    'choices'  =>
                    [
                        'Mensuel' => 'mensuel',
                        'Annuel' => 'annuel',
                        'Ponctuel' => 'ponctuel',
                    ],
                    'label' => 'A quelle fréquence souhaitez-vous donner ? ',
                    'placeholder' => '--- Select ---'
                ],
            );

        // ->add('DonnationDate')
        // ->add('IdDonneur', HiddenType::class)

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AmountDonate::class,
        ]);
    }
}
