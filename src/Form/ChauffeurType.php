<?php

namespace App\Form;

use App\Entity\Chauffeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPrenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom et prénom du chauffeur',
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
            'data_class' => Chauffeur::class,
        ]);
    }
}