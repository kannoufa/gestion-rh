<?php

namespace App\Form;

use App\Entity\DepartementService;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomFr', TextType::class, [
                'label' => 'Nom de département/service (en Français)',
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'Nom du département en Français ...'
                ]
            ])
            ->add('NomAr', TextType::class, [
                'label' => 'Nom de département/service (en Arabe)',
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'Nom du département en Arabe ...'
                ]
            ])
            ->add('chef', EntityType::class, [
                'label' => 'Le chef de département/service',
                "class" => User::class,
                "choice_label" => function ($user) {
                    return $user->getPersonnel()->getNom() . ' ' . $user->getPersonnel()->getPrenom();
                },
                "attr" => [
                    "class" => "form-control"
                ]
            ])->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DepartementService::class,
        ]);
    }
}