<?php

namespace App\Form;

use App\Entity\Absence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filiere', ChoiceType::class, [
                'choices' => $this->getFilieres(),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('cause', ChoiceType::class, [
                'choices' => $this->getCauses(),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('duree', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'عدد الأيام...',
                    'class' => 'form-control'
                ],
            ])
            ->add('apartir', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'jj/mm/aaaa ابتداءا من',
                    'class' => 'form-control'
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
        $output = [];
        foreach ($filieres as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
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