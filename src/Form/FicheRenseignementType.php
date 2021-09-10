<?php

namespace App\Form;

use App\Entity\FicheRenseignement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FicheRenseignementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sexe', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                ]
            ])
            ->add('lieunaiss', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'lieu de naissance ...'
                ]
            ])
            ->add('nationalite', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'nationalité en Français ...'
                ]
            ])
            ->add('etatcivil', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'état civil en Français ...'
                ]
            ])
            ->add('situationconj', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'situation de conjoint ...'
                ]
            ])
            ->add(
                'doticonj',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control",
                        'placeholder' => 'doti de conjoint ...'
                    ]
                ]
            )
            ->add('nbrenfant', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'nombre d\'enfant ...'
                ]
            ])
            ->add('grade', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'grade ...'
                ]
            ])
            ->add('echelle', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'echelle ...'
                ]
            ])
            ->add('indice', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'indice ...'
                ]
            ])
            ->add('daterecrut', DateType::class, [
                "attr" => [
                    "class" => "form-control",
                ]
            ])
            ->add('diplome', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'diplome ...'
                ]
            ])
            ->add('adpersonnel', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'adresse personnel ...'
                ]
            ])
            ->add('advacance', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'adresse de vacance ...'
                ]
            ])
            ->add('telephonne', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'téléphone ...'
                ]
            ])
            ->add(
                'Envoyer',
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheRenseignement::class,
        ]);
    }
}