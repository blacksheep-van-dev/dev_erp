<?php

namespace App\Form;

use App\Entity\PriceList;
use App\Entity\PriceListPrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// entity field type
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// priceListPriceType
use App\Form\PriceListPriceType;
use Onlinq\FormCollectionBundle\Form\OnlinqCollectionType;


class PriceListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('startDate')
            ->add('endDate')
            ->add('agency')
            ->add('productCategory')
            // collection of PriceListPrices
            // ->add('priceListPrices', EntityType::class, [
            //     'class' => PriceListPrice::class,
            //     'choice_label' => 'price',
            //     'multiple' => true,
            //     'expanded' => true,
            // ])
            ->add('priceListPrices', OnlinqCollectionType::class, [
                'entry_type' => PriceListPriceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'prototype_name' => '__name__',
                'entry_options' => [
                    'label' => false,
                ],
                'mapped' => true,
              
                
            ])
            
            
   
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceList::class,
        ]);
    }
}
