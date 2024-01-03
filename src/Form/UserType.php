<?php
namespace App\Form;
use Symfony\Component\Form\Event\PreSubmitEvent;
use App\Entity\User;
use App\Entity\Agency;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoiceToValueTransformer;
//file upload
use Symfony\Component\Form\Extension\Core\Type\FileType;
//password
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//EntityType
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfonycasts\DynamicForms\DependentField;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agence;

class UserType extends AbstractType
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);
            $builder
            ->add('email')
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
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin Agency' => [
                        'Agent de production' => 'ROLE_agentProd',
                        'Agent de comptoir' => 'ROLE_agentComptoir',
                        'Call Center' => 'ROLE_callCenter',
                        'Responsable Agence' => 'ROLE_respAgence',
                        'Resp de Parc Agences Propes' => 'ROLE_respAgenceProp',
                        'Resp Régional Agences Licenciés' => 'ROLE_respAgenceLic',
                        'Resp Secteur Point Relais' => 'ROLE_respPtRelais',
                    ],
                    'Admin Company' => [
                        'Admin Société' => 'ROLE_adminSociete',
                        'Resp Parc Agences Propes' => 'ROLE_respAgenceProp',
                        'Resp Parc Agences Licencies' => 'ROLE_respAgenceLic',
                    ],
                ],
                'multiple' => true,
                // 'expanded' => true,
                // 'data' => $options['data']->getRoles(),
            ])


            ->add('agencies', EntityType::class, [
                'label' => 'Choisir une agence',
                'multiple' => true,
                'expanded' => false,
                'class' => Agency::class,
                'choice_label' => 'name',
                "required" => false,
                'row_attr' => ['class' => 'agenceZone'],
                'placeholder' => 'Choisissez une agence',
                'attr' => [
                    'class' => 'form-control',
                ],
                //read only
                // 'disabled' => true,
            ])

            ->add('company', EntityType::class, [
                'label' => 'Choisir une société',
                'multiple' => false,
                'class' => Company::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'companyZone'],

                "required" => false,
                'placeholder' => 'Choisissez une société',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);

        // role Array to string conversion


    }
}
