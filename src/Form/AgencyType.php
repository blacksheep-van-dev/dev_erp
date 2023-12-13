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
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\UX\Dropzone\Form\DropzoneType;





class AgencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',  TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
          
            
            // type select Agence Propre ou Franchise ChoiceType
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Agence Propre' => 'Agence Propre',
                    'Franchise' => 'Franchise',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            // phone
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            //email
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            //address UxCollectionType
            ->add('addresses', UxCollectionType::class, [
                'entry_type' => AddressType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'form-control',
                ],
                //add label
                //minimum of 1 address
                'min' => 0,
                //maximum of 5 addresses
                'max' => 3,
                //add button label
                'add_label' => 'Ajouter une adresse',
                'by_reference' => false,
                
            ])


            //picture DropzoneType
            ->add('picture', DropzoneType::class, [
                'label' => 'Visuel',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
               
            ])


            ->add('description', CKEditorType::class, [
                'label' => 'Description',
                'config' => [
                    'uiColor' => '#ffffff',
                    'toolbar' => 'full',
                    'required' => false,
                ],
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'mapped' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'label' => 'Société parente',

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
                'label' => 'Utilisateurs',
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
