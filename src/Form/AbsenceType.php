<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Absence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cause', ChoiceType::class, [
                'choices' => $this->getCauses(),
                'attr' => [
                    'class' => 'form-control text-right'
                ]
            ])
            ->add('duree', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => '... عدد الأيام',
                    'class' => 'form-control text-right'
                ],
            ])
            ->add('apartir', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa ابتداءا من',
                    'class' => 'form-control text-right'
                ],
            ])->add('brochure', FileType::class, [
                'label' => 'Motif (.PDF )',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez respecter le format(.pdf)',
                    ])
                ],
            ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Absence::class,
        ]);
    }

    public function getFilieres()
    {
        $filieres = Absence::FILIERE;
        return $filieres;
    }

    public function getCauses()
    {
        $causes = Absence::CAUSE;
        $output = [];
        foreach ($causes as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}