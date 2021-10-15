<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\Equipe;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipe',EntityType::class,[
                'class'=> Equipe::class,
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                ]
            ])
            ->add('titre',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'titre de l\'article',
                ]
            ])
            ->add('introduction',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'introduction de l\'article',
                ]
            ])
            ->add('metaDescription',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'meta description',
                ]
            ])
            ->add('contenu',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('photoEnAvant',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('photoDeFond',FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
