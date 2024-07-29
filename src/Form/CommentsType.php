<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
            'label' => 'Votre nom ou pseudo' ])
            ->add('comments',TextareaType::class,[
                'label' => 'Postez votre avis' ])
            ->add('rating',IntegerType::class,[
                'label' => 'Laissez nous une note (de 1 à 5)',
                'attr' => ['min' => 1, 'max' => 5],
            ])
            ->add('isArchived',CheckboxType::class,[
                'label' => 'A archiver',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
