<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// entities 
use App\Entity\Agency;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label'=>'Nom de la société'])
            ->add('siren', null, ['label'=>'Siren'])
            ->add('siret', null, ['label'=>'Siret'])
            ->add('creationDate', null, ['label'=>'Date de création'])
            ->add('tvaintra', null, ['label'=>'TVA intra'])
            
            // add Agencies choice
            ->add('Agencies', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'mapped' => true,
                'label' => 'Agences',


            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
