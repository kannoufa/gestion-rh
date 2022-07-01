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
                'label' => false,
                'attr' => [
                    'placeholder' => 'P.P.R',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])->add('nom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'NOM',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])->add('prenom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'PRENOM',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])->add('fonction', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'FONCTION',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])->add('grade', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'GRADE',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-gradient-primary mb-2'
                ],
            ]);
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