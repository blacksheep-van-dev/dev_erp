<?php

namespace App\Form;

use App\Entity\OptionStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class OptionStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('agency', null, [
                'choice_label' => 'name',
                'placeholder' => 'Séléction de l\'agence',
                'label' => 'Agence',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('options', null, [
                'choice_label' => 'label',
                'placeholder' => 'Séléction de l\'option',
                'label' => 'Option',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('quantity', null, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('price', null, [
                'label' => 'Prix',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('enabled', CheckboxType::class, [
                'label'    => 'Actif',
                'required' => false,
                'attr' => [
                    'class' => 'mb-3'
                ]
            ])
            // ->add('optionId')

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OptionStock::class,
        ]);
    }
}
