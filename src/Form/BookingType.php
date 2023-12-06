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
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
//FormEvents
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
                'property_path' => 'bookingAgencySource',
                
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

        
            ->add('bookingItems', UxCollectionType::class, [
                'entry_type' => BookingItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'allow_drag_and_drop' => true,
                'drag_and_drop_filter' => 'input,textarea,a,button,label',
                'display_sort_buttons' => true,
                'add_label' => 'Add an item',
                'min' => 0,
                'max' => 10,
                'by_reference' => false,
            ])



            ->add('OptionStocks', EntityType::class, [
                'class' => OptionStock::class,
                'choice_label' => 'options',
                'multiple' => true,
                'expanded' => true,
        //         'query_builder' => function (OptionStockRepository $optionStockRepository) {
        //             // return $productRepository->findProductWithoutEvent(1, '2021-01-01', '2021-01-31');
        //             // return products of chosen agency
        //             return $optionStockRepository->createQueryBuilder('o')
        //                 ->where('o.agency = :agency')
        // //              ->setParameter dyanmic value
        //                 ->setParameter('agency', 1);

                        
                        
        //         }
            ])







            
        

            ;


            // $builder->addDependent('badRatingNotes', 'rating', function(DependentField $field, ?int $bookingAgencySource) {
            //     if ($bookingAgencySource == null) {
            //         return; // field not needed
            //     }
    
            //     $field->add(TextareaType::class, [
            //         'label' => 'What went wrong?',
            //         'attr' => ['rows' => 3],
            //         'help' => sprintf('Because you gave a %d rating, we\'d love to know what went wrong.', $bookingAgencySource),
            //     ]);
            // });
    
        }
            

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
