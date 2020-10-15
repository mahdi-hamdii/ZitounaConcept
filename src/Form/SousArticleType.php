<?php

namespace App\Form;

use App\Entity\SousArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('tabDimension', CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('images',FileType::class,array(
                'mapped'=>false,
                'multiple'=>true,
                'required'=>false
            ))
            ->add('catalogArticle')
            ->add('sousTitre1',TextType::class,array(
                'required'=>false
            ))
            ->add('desc1SousT1',TextType::class,array(
                'required'=>false
            ))
            ->add('desc2SousT1',TextType::class,array(
                'required'=>false
            ))
            ->add('desc3SousT1',TextType::class,array(
                'required'=>false
            ))
            ->add('sousTitre2',TextType::class,array(
                'required'=>false
            ))
            ->add('desc1SousT2',TextType::class,array(
                'required'=>false
            ))
            ->add('desc2SousT2',TextType::class,array(
                'required'=>false
            ))
            ->add('desc3SousT2',TextType::class,array(
                'required'=>false
            ))
            ->add('sousTitre3',TextType::class,array(
                'required'=>false
            ))
            ->add('desc1SousT3',TextType::class,array(
                'required'=>false
            ))
            ->add('desc2SousT3',TextType::class,array(
                'required'=>false
            ))
            ->add('desc3SousT3',TextType::class,array(
                'required'=>false
            ))
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousArticle::class,
        ]);
    }
}
