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
// auto complete
use Symfony\Component\Form\Extension\Core\Type\TextType;
//TextareaType
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//TinymceType


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
            ->add('description', TextareaType::class, [
                'attr' => ['id' => 'agenceDescription'],
                'required' => false,
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'mapped' => true,

            ])
        //     ->add('users', UserAutocompleteField::class,
        //   )   
            
            //  add list of existing users
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => true,
                'expanded' => false,
                'mapped' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'autocomplete' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agency::class,

        ]);
    }
}
