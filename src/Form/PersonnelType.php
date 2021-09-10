<?php

namespace App\Form;

use App\Entity\Personnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PersonnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ppr', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Numéro P.P.R ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('cin', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'CIN ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Français',
                    'class' => 'form-control'
                ],
            ])
            ->add('nom_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Arabe',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'prénom en Français',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Arabe',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_naissance', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('date_recrutement', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('sexe_ar', ChoiceType::class, [
                'choices' => $this->getSexeAr(),
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('nationalite_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nationalité en Arabe',
                    'class' => 'form-control'
                ],
            ])
            ->add('echellon', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'echellon ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_effet_echelon', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('anciennete_echelon', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'année d\'ancienneté ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('grade_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'grade en Arabe',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_effet_grade', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('anciennete_grade', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'année d\'ancienneté',
                    'class' => 'form-control'
                ],
            ])
            ->add('situation_administrative_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'situation administrative en Arabe ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('fonction', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'fonction ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_fonction', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('anciennete_administrative', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'année ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('etablissement_ar', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'établissement en Arabe',
                    'class' => 'form-control'
                ],
            ])
            ->add('position', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'position ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('date_position', DateType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('situation_familiale_ar', ChoiceType::class, [
                'choices' => $this->getSituationFamilireAr(),
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'email ...',
                    'class' => 'form-control'
                ],
            ])
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnel::class,
        ]);
    }

    public function getSexeAr()
    {
        $sexe_ar = Personnel::SEXEAR;
        $output = [];
        foreach ($sexe_ar as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }

    public function getSituationFamilireAr()
    {
        $situation_familiale_ar = Personnel::SITUATIONFAMILIAIREAR;
        $output = [];
        foreach ($situation_familiale_ar as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}