<?php

namespace App\Form;

use App\Entity\Parametre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ParametreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logoFile', FileType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'btn btn-block btn-gradient-secondary mb-2'
                ],
            ])
            ->add('enTeteOrdreMissionFile', FileType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'btn btn-block btn-gradient-secondary mb-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parametre::class,
        ]);
    }
}