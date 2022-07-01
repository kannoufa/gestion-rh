<?php

namespace App\Form;

use App\Entity\AbsenceSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AbsenceSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ppr', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'P.P.R',
                    "class" => "form-control mb-4 mr-sm-2"
                ],
            ])
            ->add('annee', ChoiceType::class, [
                'choices' => $this->getYears(),
                'choice_label' => function ($year) {
                    return
                        $year . '/' . ((new \DateTime('01/01/' . $year))->modify('+1 year')->format('Y'));
                },
                'required' => false,
                'label' => false,
                'attr' => [
                    "class" => "form-control mb-4 mr-sm-2"
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-gradient-primary mb-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AbsenceSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getYears()
    {
        $now = new \DateTime('now');
        $start_year = new \DateTime('09/01/' . $now->format('Y')); #debut de septembre
        for ($i = 0; $i < 10; $i++) {
            if ($now > $start_year)
                $years[] = $start_year->format('Y');
            $year = $now->modify('-1 year');
            $years[] = $year->format('Y');
        }
        return $years;
    }
}