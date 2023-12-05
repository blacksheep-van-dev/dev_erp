<?php

namespace App\Form;

use App\Entity\PriceListPrice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceListPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price')
            ->add('minimalDuration', null, [
                'label' => 'Durée minimale (en jours) du booking'
            ])
            ->add('maximalDuration', null, [
                'label' => 'Durée maximale (en jours) du booking'
            ]
            )
            // ->add('PriceList')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceListPrice::class,
        ]);
    }
}
