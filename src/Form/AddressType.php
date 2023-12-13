<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Agency;
use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// auto complete
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',  TextType::class, [
            'label' => 'Nom de l adresse',
            'attr' => [
                'class' => 'form-control',
            ],
        ])


        ->add('numStreet',
            TextType::class, [
                'label' => 'Numéro de rue',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('street',
            TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
  
            ->add('city',
            TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
  
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
           
            // ->add('agency', EntityType::class, [
            //     'class' => Agency::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            // ->add('company', EntityType::class, [
            //     'class' => Company::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
