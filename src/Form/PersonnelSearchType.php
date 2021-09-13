<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\PersonnelSearch;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonnelSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ppr', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'P.P.R',
                    'class' => 'col'
                ],
            ])->add('nom', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'NOM',
                    'class' => 'col'
                ],
            ])->add('prenom', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'PRENOM',
                    'class' => 'col'
                ],
            ])->add('fonction', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'FONCTION',
                    'class' => 'col'
                ],
            ])->add('grade', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'GRADE',
                    'class' => 'col'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'col btn btn-success'
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PersonnelSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}