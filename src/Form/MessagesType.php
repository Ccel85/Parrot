<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $formOptions): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom' ])

            ->add('email',EmailType::class,[
                'label' => 'Votre email'
                ])

            ->add('subject', TextType::class, [
                'required' => true,
                'attr' => $formOptions['subject_readonly'] ? ['readonly' => true] : [],
                'label' => 'Votre sujet',
                ])
            ->add('message',TextareaType::class,[
                    'label' => 'Votre message' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
            'subject_readonly' => false,  // Valeur par défaut : pas en lecture seule
        ]);
    }
}
