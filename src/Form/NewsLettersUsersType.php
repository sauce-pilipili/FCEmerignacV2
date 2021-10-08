<?php

namespace App\Form;

use App\Entity\Newletters\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class NewsLettersUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputmail'
                ]

            ])
            ->add('is_rgpd',CheckboxType::class,[
                'attr'=>[
                    'class'=> 'inputrgpd'
                ],
                'constraints'=>[
                    new IsTrue([
                        'message'=>'Vous devez accepter la collecte de vos données personnelles'
                    ])
                ],
                'label'=>' j\'accepte la collecte de mes données personnelles'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
