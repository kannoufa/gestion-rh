<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminOrdreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vehicule', EntityType::class, [
                'label' => 'Véhicule',
                "class" => Vehicule::class,
                'choice_label' => function ($vehicule) {
                    return $vehicule->getNom() . ' - ' . $vehicule->getMatricule();
                },
                "attr" => [
                    "class" => "form-control"
                ]
            ])->add('chauffeur', EntityType::class, [
                'label' => 'Chauffeur',
                "class" => Chauffeur::class,
                "choice_label" => "nomPrenom",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'col button'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}