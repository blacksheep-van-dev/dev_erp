<?php

namespace App\Form;

use App\Entity\Agency;
use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
// collection type
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Nom de l\'agence'])
            // type select Agence Propre ou Franchise ChoiceType
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Agence Propre' => 'Agence Propre',
                    'Franchise' => 'Franchise',
                ],
            ])
            ->add('description', null, ['label' => 'Description'])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'mapped' => true,

            ])
            // users UxCollectionType
            ->add('users', UxCollectionType::class, [
                'entry_type' => UserType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Utilisateurs',
                'by_reference' => false,
                'prototype' => true,
                'prototype_name' => '__user__',
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'class' => 'user-collection',
                ],
            ])



            //
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agency::class,

        ]);
    }
}
