<?php

namespace App\Form;

use App\Entity\DepartementService;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomFr', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'Nom du département en Français ...'
                ]
            ])
            ->add('NomAr', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'Nom du département en Arabe ...'
                ]
            ])
            ->add('chef', EntityType::class, [
                "class" => User::class,
                "choice_label" => "username",
                "attr" => [
                    "class" => "form-control"
                ]
            ])->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DepartementService::class,
        ]);
    }
}