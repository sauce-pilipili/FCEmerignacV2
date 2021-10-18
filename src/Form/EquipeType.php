<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Equipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'inputForm',
                ]
            ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'label'=>false,
                'attr'=>[
                    'class'=>'inputForm',
                ]
            ])
            ->add('scriptResultat', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                ]
            ])
            ->add('images',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
