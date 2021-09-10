<?php

namespace App\Form;

use App\Entity\EnregistrementEntree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnregistrementEntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieu_naissance_ar', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '... مكان الازدياد',
                    'class' => 'form-control text-right'
                ],
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '... العنوان الشخصي',
                    'class' => 'form-control text-right'
                ],
            ])->add('Enregistrer', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EnregistrementEntree::class,
        ]);
    }
}