<?php

namespace App\Form;

use App\Entity\Garage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class GarageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom'
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email'
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telephone'
            ])
            ->add('adress',TextType::class,[
                'label' => 'Adresse'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garage::class,
        ]);
    }
}