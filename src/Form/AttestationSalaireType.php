<?php

namespace App\Form;

use App\Entity\AttestationSalaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AttestationSalaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Type', ChoiceType::class, [
                'choices' => $this->getType(),
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('Envoyer', SubmitType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttestationSalaire::class,
        ]);
    }

    public function getType()
    {
        $type = AttestationSalaire::TYPE;
        $output = [];
        foreach ($type as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}