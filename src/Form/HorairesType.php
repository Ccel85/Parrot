<?php

namespace App\Form;

use App\Entity\Horaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class HorairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('joursOuverture',ChoiceType::class,[
                'choices'  => [
                    'Lundi'=>'Lundi',
                    'Mardi'=>'Mardi' ,
                    'Mercredi'=>'Mercredi',
                    'Jeudi'=>'Jeudi',
                    'Vendredi'=>'Vendredi' ,
                    'Samedi'=>'Samedi',
                    'Dimanche'=>'Dimanche',
                ],
                
            ])

            ->add('heuresDebutAM',TimeType::class)

            ->add('heuresFinAM',TimeType::class, [
                'widget' => 'single_text',
                
            ])
            ->add('heuresDebutPM',TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('heuresFinPM',TimeType::class, [
                'widget' => 'single_text',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaires::class,
        ]);
    }
}
