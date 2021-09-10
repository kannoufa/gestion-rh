<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'objet du message ...'
                ]
            ])
            ->add('message', TextareaType::class, [
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'contenu du message ...'
                ]
            ])
            ->add('recipient', EntityType::class, [
                "class" => User::class,
                "choice_label" => "username",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add(
                'envoyer',
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}