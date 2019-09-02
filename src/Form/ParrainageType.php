<?php

namespace App\Form;

use App\Entity\Filleul;
use App\Repository\FilleulRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParrainageType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'choices' => [
                        'Fille' => 'girl',
                        'Garçon' => 'boy',
                        'Peu importe' => 'whatever',
            ]
            ])

            ->add('age',ChoiceType::class, [
              'choices' => [
                      '3-7 ans' => 'baby',
                      '8-12 ans' => 'young',
                      '13-17 ans' => 'teenager',
                      'Peu importe' => 'whatever',
              ]
          ])
//            ->add('pays', EntityType::class, [
//                'class' => Filleul::class,
//
//                'query_builder' => function (EntityRepository $fr) {
//                    return $fr->createQueryBuilder('f')
//                        ->select('f.pays')
//                        ->orderBy('f.pays', 'ASC')
//                        ->distinct()
//                        ;
//                },
//                'choice_label' => 'pays',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filleul::class,
        ]);
    }
}
