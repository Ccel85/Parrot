<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Images;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('path_images', EntityType::class, [
                'class' => Annonces::class,
                'choice_label' => 'id',
                'mapped' => false, // Tell Symfony this field is not mapped to the Image entity
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
        ]);
    }
}
