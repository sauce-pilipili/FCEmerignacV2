<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Joueurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ]
            ])
            ->add('name', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ]
            ])
            ->add('age', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ]
            ])
            ->add('description', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ]
            ])
            ->add('poste', ChoiceType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ],
                'choices'=>[
                    'Gardien'=> 'Gardien',
                    'Gardiennne'=> 'Gardienne',
                    'Défenseur'=>'Défenseur',
                    'Défenseuse'=>'Défenseuse',
                    'Milieu'=>'Milieu',
                    'Attaquant'=>'Attaquant',
                    'Attaquante'=>'Attaquante',
                ]
            ])
            ->add('photoDebout',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('photoPortrait',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('equipe',EntityType::class,[
                'class'=> Equipe::class,
                'label'=> false,
                'attr'=>[
                    'class'=> 'inputForm'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueurs::class,
        ]);
    }
}
