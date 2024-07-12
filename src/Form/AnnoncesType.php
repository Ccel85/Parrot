<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('constructeur',TextType::class)
            ->add('modele',TextType::class)
            ->add('carburant',ChoiceType::class,[
                'choices'  => [
                        'Diesel'=>'Diesel',
                        'Essence'=>'Essence' ,
                        'Electrique'=>'Electrique',
                        'Hybride'=>'Hybride',
                        'Flexfuel'=>'Flexfuel',
                        ]
                        ])
            ->add('prix',MoneyType::class)
            ->add('km',IntegerType::class)
            ->add('année',IntegerType::class)
            ->add('created_at',DateTimeType::class)
            ->add('couleur',TextType::class)
            ->add('boite',IntegerType::class)
            ->add('puissance_fiscal',IntegerType::class)
            ->add('puissance',IntegerType::class)
            ->add('nbre_porte',IntegerType::class)
            ->add('equipement_interieur',TextType::class)
            ->add('equipement_exterieur',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
