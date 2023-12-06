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
   
            ->add('priceListPrices', PriceListPriceType::class, [
                'label' => false,
                'entry_type' => PriceListPriceType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
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
