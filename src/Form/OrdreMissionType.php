<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\OrdreMission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrdreMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'objet de ma mission ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('destination', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'destination de la mission (adresse) ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('membres', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'les membres de la mission ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_depart', DateType::class, [
                'label' => 'Date de départ',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'date de départ de la mission ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('heure_dep', TextType::class, [
                'label' => 'Heure de départ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'hh:mm',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_retour', DateType::class, [
                'label' => 'Heure de retour',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'date de retour de la mission  ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('heure_retour', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'hh:mm',
                    'class' => 'form-control'
                ],
            ])
            ->add('frais', ChoiceType::class, [
                'choices' => $this->getFrais(),
                'required' => true,
                'attr' => [
                    'placeholder' => 'Oui/Non?',
                    'class' => 'form-control'
                ],
            ])->add('motifFile', FileType::class, [
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer l\'ordre de mission',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrdreMission::class,
        ]);
    }

    public function getFrais()
    {
        $frais = OrdreMission::FRAIS;
        $output = [];
        foreach ($frais as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}