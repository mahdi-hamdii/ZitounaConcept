<?php

namespace App\Form;

use App\Entity\sousCategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('image',FileType::class,array(
                'required'=>true,
                'mapped'=>false,
                'constraints'=>array(
                    new \Symfony\Component\Validator\Constraints\Image()
                )
            ))
            ->add('categorie')
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => sousCategorie::class,
        ]);
    }
}
