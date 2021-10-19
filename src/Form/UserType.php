<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>false,
                'attr'=>['class'=>'inputForm']
            ])
            ->add('roles', ChoiceType::class,[
                'label'=>false,
                'attr'=>['class'=>'inputForm'],
                'choices'=>[
                    'administrateur'=> 'ROLE_ADMIN',
                    'responsable club'=>'ROLE_RESPONSABLE',
                    'éditeur'=>'ROLE_EDITOR',
                ],
                'multiple' => true
            ])
            ->add('password',PasswordType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'inputForm']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
