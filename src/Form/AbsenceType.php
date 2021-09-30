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
                'choices' => $this->getCauses(),
                'attr' => [
                    'class' => 'form-control text-right'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'duree (nombre du jours d\'absence)',
                'required' => true,
                'attr' => [
                    'placeholder' => '... عدد الأيام',
                    'class' => 'form-control text-right'
                ],
            ])
            ->add('apartir', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa ابتداءا من',
                    'class' => 'form-control text-right'
                ],
            ])
            ->add('jusquA', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa الى',
                    'class' => 'form-control text-right'
                ],
            ])
            ->add('motifFile', FileType::class, [
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer la demande',
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