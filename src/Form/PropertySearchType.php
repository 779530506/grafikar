<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice',IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>['placeholder'=>'le prix max']
            ])
            ->add('minSurface',IntegerType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>['placeholder'=>'la surface min']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method'=> 'get',
            'csrf_protection'=>false
        ]);
    }
}
