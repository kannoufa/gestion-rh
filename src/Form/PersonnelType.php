<?php

namespace App\Form;

use App\Entity\DepartementService;
use App\Entity\Personnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('cin', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'CIN ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Français',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('nom_ar', TextType::class, [
                'label' => 'Nom (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Arabe',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'prénom en Français',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('prenom_ar', TextType::class, [
                'label' => 'Prénom (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'nom en Arabe',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_recrutement', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('sexe_ar', ChoiceType::class, [
                'label' => 'Sexe (Arabe)',
                'choices' => $this->getSexeAr(),
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('nationalite_ar', TextType::class, [
                'label' => 'Nationalité (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'nationalité en Arabe',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('echellon', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'échellon ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_effet_echelon', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('anciennete_echelon', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'années d\'ancienneté ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('grade_ar', TextType::class, [
                'label' => 'Grade (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'grade en Arabe',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_effet_grade', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('anciennete_grade', IntegerType::class, [
                'label' => 'ancienneté grade',
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'années d\'ancienneté',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('situation_administrative_ar', TextType::class, [
                'label' => 'Situation administrative (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'situation administrative en Arabe ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('fonction', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'fonction ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_fonction', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('anciennete_administrative', IntegerType::class, [
                'label' => "Ancienneté administrative",
                'required' => true,
                'attr' => [
                    'placeholder' => 'nombre d\'années ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('etablissement_ar', TextType::class, [
                'label' => 'établissement (Arabe)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'établissement en Arabe',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('position', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'position ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('date_position', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('situation_familiale_ar', ChoiceType::class, [
                'label' => 'Situation familiale (Arabe)',
                'choices' => $this->getSituationFamilireAr(),
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'email ...',
                    'class' => 'form-control mb-2 mr-sm-2',
                ],
            ])->add('sexe', ChoiceType::class, [
                'choices' => $this->getSexe(),
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ]
            ])
            ->add('lieunaiss', TextType::class, [
                'label' => "Lieu de naissance",
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'lieu de naissance ...'
                ]
            ])
            ->add('nationalite', TextType::class, [
                'label' => 'Nationalité',
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'nationalité en Français ...'
                ]
            ])
            ->add('etatcivil', ChoiceType::class, [
                'label' => 'état civil',
                'choices' => $this->getEtatCivil(),
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'état civil en Français ...'
                ]
            ])
            ->add('situationconj', TextType::class, [
                'required' => false,
                'label' => "Situation de conjoint",
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'situation de conjoint ...'
                ]
            ])
            ->add('doticonj', TextType::class, [
                'required' => false,
                'label' => 'Doti du conjoint',
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'doti de conjoint ...'
                ]
            ])
            ->add('nbrenfant', IntegerType::class, [
                'required' => false,
                'empty_data' => 0,
                'label' => 'Nombre d\'enfants',
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'nombre d\'enfant ...'
                ]
            ])
            ->add('grade', TextType::class, [
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'grade ...'
                ]
            ])
            ->add('echelle', TextType::class, [
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'echelle ...'
                ]
            ])
            ->add('indice', TextType::class, [
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'indice ...'
                ]
            ])
            ->add('diplome', TextType::class, [
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'diplome ...'
                ]
            ])
            ->add('adpersonnel', TextType::class, [
                'label' => "Adresse personnel",
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'adresse personnel ...'
                ]
            ])
            ->add('advacance', TextType::class, [
                'required' => false,
                'label' => "Adresse de vacance",
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'adresse de vacance ...'
                ]
            ])
            ->add('telephonne', TextType::class, [
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                    'placeholder' => 'téléphone ...'
                ]
            ])->add('departementService', EntityType::class, [
                "class" => DepartementService::class,
                "choice_label" => "nomFr",
                "attr" => [
                    'class' => 'form-control mb-2 mr-sm-2',
                ]
            ])->add('imageFile', FileType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'btn btn-block btn-gradient-secondary mb-2'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-block btn-gradient-primary mb-2'
                ],
            ]);
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

    public function getSexe()
    {
        $sexe = Personnel::SEXE;
        $output = [];
        foreach ($sexe as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }

    public function getEtatCivil()
    {
        $etat = Personnel::ETATCIVIL;
        $output = [];
        foreach ($etat as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}