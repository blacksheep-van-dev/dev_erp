<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Agency;
use App\Entity\BrandModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ProductCategory;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // productCategory entitytype
            ->add('productCategory', EntityType::class, [
                'class' => ProductCategory::class,
                'choice_label' => 'label',
            ])

            ->add('agency', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
            ])
            
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Véhicule Particulier' => 'Véhicule Particulier',
                    'Véhicule Pro' => 'Véhicule Pro',
                ],
            ])
            ->add('label')

            // brand
            ->add('model', EntityType::class, [
                'class' => BrandModel::class,
                'choice_label' => 'label',
            ])

            // ->add('model', OnlinqCollectionType::class, [



            // brand
            // ->add('model')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
