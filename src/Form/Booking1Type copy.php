<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Option;
use App\Entity\User;
use Onlinq\FormCollectionBundle\Form\OnlinqCollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//entitytype
use Symfony\Component\Form\AbstractType;
// collection
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
// choice type
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

//DateTimeImmutable
use Symfony\Component\OptionsResolver\OptionsResolver;

class Booking1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('bookingAgencySource')
            ->add('bookingAgencyTarget')

            ->add('dateBegin', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
                'input' => 'datetime_immutable',
            ])

            ->add('dateEnd', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
                'input' => 'datetime_immutable',
            ])

            ->add('reference')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])

            // products collection
            ->add('products', OnlinqCollectionType::class, [
                'entry_type' => ProductType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'allow_move' => true,
                'required' => false,
            ])
            // activities collection
            ->add('activities', OnlinqCollectionType::class, [
                'entry_type' => ActivityType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'allow_move' => true,
                'required' => false,
            ])


            //options entity type
            // ->add('options', EntityType::class, [
            //     'class' => Option::class,
            //     'choice_label' => 'label',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'required' => false,
            // ])

            // options collection
            ->add('options', OnlinqCollectionType::class, [
                'entry_type' => OptionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'allow_move' => true,
                'required' => false,
            ])


            //Collection $bookingItems BookingItemType
            // ->add('bookingItems', OnlinqCollectionType::class, [
            //     'entry_type' => BookingItemType::class,
            //     'entry_options' => ['label' => false],
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'allow_move' => true,
            // ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);

        // convert DateTime to DateTimeImmutable
        // $resolver->setNormalizer('dateBegin', function ($options, $value) {
        //     return $value instanceof \DateTime ? $value : new \DateTime($value);
        // });

    }
}
