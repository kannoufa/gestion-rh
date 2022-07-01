<?php

namespace App\Form;

use App\Entity\Absence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cause', ChoiceType::class, [
                'label' => 'Cause',
                'choices' => $this->getCauses(),
                'attr' => [
                    'class' => 'form-control mb-4 mr-sm-2 text-right'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'duree (nombre du jours d\'absence)',
                'required' => true,
                'attr' => [
                    'placeholder' => '... عدد الأيام',
                    'class' => 'form-control mb-4 mr-sm-2 text-right'
                ],
            ])
            ->add('apartir', DateType::class, [
                'label' => 'à partir',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa ابتداءا من',
                    'class' => 'form-control mb-4 mr-sm-2 text-right'
                ],
            ])
            ->add('jusquA', DateType::class, [
                'label' => 'Jusqu\'à',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa الى',
                    'class' => 'form-control mb-4 mr-sm-2 text-right'
                ],
            ])
            ->add('motifFile', FileType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'btn btn-gradient-secondary btn-block btn-sm mr-2 mb-2'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer la demande',
                'attr' => [
                    'class' => 'btn btn-gradient-primary mr-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Absence::class,
        ]);
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