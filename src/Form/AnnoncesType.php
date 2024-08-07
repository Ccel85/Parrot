<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('constructeur',TextType::class)
            ->add('modele',TextType::class,[
            'label' => 'Modele',
            ])
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
            ->add('annee',IntegerType::class,[
                'label' => 'Année de mise en circulation',
                ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'attr' => ['readonly' => true], // optionnel, si vous souhaitez rendre le champ non éditable
            ])
            ->add('couleur',TextType::class)
            ->add('boite',ChoiceType::class,[
                'choices'  => [
                        'Manuelle'=>'Manuelle',
                        'Automatique'=>'Automatique'
                        ]
                        ])
            ->add('puissanceFiscal',IntegerType::class,[
                'label' => 'Puissance fiscale',
                ])
            ->add('puissance',IntegerType::class)
            ->add('nbrePorte',IntegerType::class,[
                'label' => 'Nombre de porte',
                ])
            ->add('equipementInterieur',TextareaType::class,[
                'label' => 'Equipement interieur',
                ])
            ->add('equipementExterieur',TextareaType::class,[
                'label' => 'Equipement Exterieur',
                ])
            ->add('autresEquipements',TextareaType::class,[
                    'label' => 'Equipement Autre',
                    ])
                    ->add('images', FileType::class, [
                        'label' => 'Images (JPEG/PNG files)',
                        'mapped' => false,
                        'required' => false,
                        'multiple' => true,
                        'constraints' => [
                            new File([
                                'maxSize' => '5M',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                ],
                                'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image',
                            ])
                        ]
                    ])
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
