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
                ],
            ])->add('nom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'NOM',
                ],
            ])->add('prenom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'PRENOM',
                ],
            ])->add('fonction', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'FONCTION',
                ],
            ])->add('grade', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'GRADE',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'col btn-sm btn-success'
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