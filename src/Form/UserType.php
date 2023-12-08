<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//file upload
use Symfony\Component\Form\Extension\Core\Type\FileType;
//password
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//EntityType
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles') transform
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    // 'Agency' => 'ROLE_AGENCY',
                    // 'Company' => 'ROLE_COMPANY',
                ],
                'multiple' => true,
                'expanded' => true,
            ])



            ->add('password', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',
                ],
            ])
            ->add('firstName')
            ->add('LastName')
            ->add('isVerified')
            //picure upload
            ->add('picture', FileType::class, [
                'label' => 'Picture (JPG, PNG, JPEG file)',
                'mapped' => false,
                'required' => false,
                'multiple' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'class' => 'form-control',
                ],
            ])
            ->add('agencies', EntityType::class, [
                'label' => 'Choisir une agence',
                'multiple' => true,
                'class' => Agency::class,
                // choice label nom et prenom
                // 'choice_label' => 'nom',
                'choice_label' => 'name',
                // expanded => true
                'expanded' => true,

                "required" => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                //read only
                'disabled' => true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

        // role Array to string conversion
        

    }
}
