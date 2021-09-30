<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\HistoriqueSearch;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HistoriqueSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ppr', TextType::class, [
                'required' => false,
                'label' => false,  # pour retirer le label
                'attr' => [
                    'placeholder' => 'P.P.R ...',
                    'class' => 'form-control col'
                ],
            ])->add('typeDemande', ChoiceType::class, [
                'choices' => $this->getType(),
                'label' => false,  # pour retirer le label
                'attr' => [
                    'class' => 'form-control col'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'col btn btn-info'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getType()
    {
        $types = HistoriqueSearch::TYPEDEMANDE;
        $output = [];
        foreach ($types as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}