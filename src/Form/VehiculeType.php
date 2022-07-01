<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom du véhicule ...',
                    'class' => 'form-control mb-4 mr-sm-2',
                ],
            ])
            ->add('matricule', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'matricule ...',
                    'class' => 'form-control mb-4 mr-sm-2',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-block btn-gradient-primary mb-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}