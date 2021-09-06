<?php

namespace App\Form;

use App\Entity\FicheRenseignement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FicheRenseignementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('doti')
            ->add('cin')
            ->add('nom')
            ->add('prenom')
            ->add('sexe')
            ->add('datenaiss')
            ->add('lieunaiss')
            ->add('nationalite')
            ->add('etatcivil')
            ->add('situationconj')
            ->add('doticonj')
            ->add('nbrenfant')
            ->add('grade')
            ->add('fonction')
            ->add('echelle')
            ->add('indice')
            ->add('daterecrut')
            ->add('diplome')
            ->add('adpersonnel')
            ->add('adelectronique')
            ->add('advacance')
            ->add('telephonne');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheRenseignement::class,
        ]);
    }
}