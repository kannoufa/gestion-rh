<?php

namespace App\Form;

use App\Entity\AttestationTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttestationTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Demander une attestation de travail',
                'attr' => [
                    'class' => 'btn btn-gradient-primary mr-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttestationTravail::class,
        ]);
    }
}