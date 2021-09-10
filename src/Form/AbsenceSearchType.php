<?php

namespace App\Form;

use App\Entity\AbsenceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AbsenceSearchType extends AbstractType
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
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'col btn btn-success'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AbsenceSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}