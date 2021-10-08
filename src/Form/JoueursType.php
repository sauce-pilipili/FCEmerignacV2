<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Joueurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('name')
            ->add('age')
            ->add('description')
            ->add('poste')
            ->add('photoDebout',FileType::class,[
                'label' => 'photo debout',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('photoPortrait',FileType::class,[
                'label' => 'photo portrait',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('equipe',EntityType::class,[
                'class'=> Equipe::class,
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
