<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//EntityType
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//CollectionType
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Onlinq\FormCollectionBundle\Form\OnlinqCollectionType;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;//Symfonycasts\DynamicForms\DependentField::class
use App\Repository\AgencyRepository;
use App\Repository\BookingRepository;
//product
use App\Entity\Product;
use App\Repository\ProductRepository;
//optionStock
use App\Entity\OptionStock;
use App\Repository\OptionStockRepository;
//ChoiceType
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder = new DynamicFormBuilder($builder);


        $builder
            ->add('reference')
            ->add('dateBegin')
            ->add('dateEnd')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email'
            ])
            ->add('bookingAgencySource', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
                // 'query_builder' => function (AgencyRepository $agencyRepository) {
                //     // return $productRepository->findProductWithoutEvent(1, '2021-01-01', '2021-01-31');
                //     // return products of chosen agency
                //     return $agencyRepository->createQueryBuilder('a')
                //         ->where('a.id = :agency')
                //         ->setParameter('agency', 1);
                // }


            ])
            ->add('bookingAgencyTarget', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
                // 'query_builder' => function (AgencyRepository $agencyRepository) {
                //     // return $productRepository->findProductWithoutEvent(1, '2021-01-01', '2021-01-31');
                //     // return products of chosen agency
                //     return $agencyRepository->createQueryBuilder('a')
                //         ->where('a.id = :agency')
                //         ->setParameter('agency', 1);
            ])

            /**Stock options choice type*/
            ->add('OptionStocks', EntityType::class, [
                'class' => OptionStock::class,

                'multiple' => true,
                'expanded' => true,
                // 'query_builder' => function (OptionStockRepository $optionStockRepository) {
                //     // return $productRepository->findProductWithoutEvent(1, '2021-01-01', '2021-01-31');
                //     // return products of chosen agency
                //     return $optionStockRepository->createQueryBuilder('os')
                //         ->where('os.id = :optionStock')
                //         ->setParameter('optionStock', 1);
                // }
            ])

            










            // bookingItems Collection
            ->add('bookingItems', OnlinqCollectionType::class, [
                'entry_type' => BookingItemType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => [
                    'class' => 'bookingItems-collection',
                ],
            ]);


            // $builder->add('rating', ChoiceType::class, [
            //     'choices' => [
            //         'Select a rating' => null,
            //         'Great' => 5,
            //         'Good' => 4,
            //         'Okay' => 3,
            //         'Bad' => 2,
            //         'Terrible' => 1
            //     ],
            // ]);


            // $builder->addDependent('bookingAgencyTarget', 'bookingAgencySource', function(DependentField $field, ?string $bookingAgencySource) {
            //     if ($bookingAgencySource == null) {
            //         return; // field not needed
            //     }
    
            //     $field->add(TextareaType::class, [
            //         'label' => 'What went wrong?',
            //         'attr' => ['rows' => 3],
            //         'help' => sprintf('Because you gave a %d rating, we\'d love to know what went wrong.', $bookingAgencySource),
            //     ]);
            // });


            ;


            $builder->addDependent('badRatingNotes', 'rating', function(DependentField $field, ?int $bookingAgencySource) {
                if ($bookingAgencySource == null) {
                    return; // field not needed
                }
    
                $field->add(TextareaType::class, [
                    'label' => 'What went wrong?',
                    'attr' => ['rows' => 3],
                    'help' => sprintf('Because you gave a %d rating, we\'d love to know what went wrong.', $bookingAgencySource),
                ]);
            });








          
        }
            

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
