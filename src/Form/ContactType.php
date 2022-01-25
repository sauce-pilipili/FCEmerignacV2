<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('demande',ChoiceType::class,[
                'required'=> true,
                'choices'=>[
                    'Sélectionnez une option'=>'',
                    'demande'=>'demande'
                ],
                'label'=>false
            ])
            ->add('name',TextType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Indiquez votre nom et prénom'
                ]
            ])
            ->add('email',EmailType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Écrivez votre adresse mail'
                ]
            ])
            ->add('tel',TelType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'Écrivez votre numéro de téléphone'
                ]
            ])
            ->add('message',TextareaType::class,[
                'required'=> true,
                'label'=>false,
                'attr'=>[
                    'cols'=>30,
                    'rows'=>10,

                ]
            ])
            ->add('check',CheckboxType::class,[
                'required'=> true,
                'label'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
