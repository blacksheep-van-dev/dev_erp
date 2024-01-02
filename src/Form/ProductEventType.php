<?php

namespace App\Form;

use App\Entity\ProductEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('dateBegin')
            ->add('dateEnd')
            ->add('km')
            ->add('product')
        ;
        // dd($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductEvent::class,
        ]);
    }
}
