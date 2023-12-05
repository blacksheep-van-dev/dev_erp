<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }



// function to return products by categories for an angency
    public function findProductByCategory($agency)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productCategory', 'pc')
            ->leftJoin('p.agency', 'a')
            ->where('a.id = :agency')
            ->setParameter('agency', $agency)
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }

    

    // function to return products by categories for an angency
    public function findProductByCategoryAndLabel($agency, $category, $label)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productCategory', 'pc')
            ->leftJoin('p.agency', 'a')
            ->where('pc.id = :category')
            ->andWhere('a.id = :agency')
            ->andWhere('p.label LIKE :label')
            ->setParameter('category', $category)
            ->setParameter('agency', $agency)
            ->setParameter('label', '%' . $label . '%')
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }

    // function to return products by categories for an angency
    public function findProductByLabel($agency, $label)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.agency', 'a')
            ->where('a.id = :agency')
            ->andWhere('p.label LIKE :label')
            ->setParameter('agency', $agency)
            ->setParameter('label', '%' . $label . '%')
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }


    


// return product which no product event for an agency
    public function findProductWithoutEvent($agency,$start,$end)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productEvents', 'pe')
            ->leftJoin('p.agency', 'a')
            ->andWhere('a.id = :agency')
            ->andWhere('pe.dateBegin NOT BETWEEN :start AND :end')
            ->andWhere('pe.dateEnd NOT BETWEEN :start AND :end')
            // pe.product is null
            // ->orWhere('pe.product is null')
            ->setParameter('agency', $agency)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('p.label', 'ASC');

            

        return $qb->getQuery()->getResult();


    

    
    }
    

    // return product which no product event for an agency
    public function findProductWithEvent($agency)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productEvents', 'pe')
            ->leftJoin('p.agency', 'a')
            ->where('pe.id is not null')
            ->andWhere('a.id = :agency')
            ->setParameter('agency', $agency)
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }

    // return product which no product event for an agency
    public function findProductWithEventByCategory($agency, $category)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productEvents', 'pe')
            ->leftJoin('p.agency', 'a')
            ->leftJoin('p.productCategory', 'pc')
            ->where('pe.id is not null')
            ->andWhere('a.id = :agency')
            ->andWhere('pc.id = :category')
            ->setParameter('agency', $agency)
            ->setParameter('category', $category)
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }

    // return product which no product event for an agency
    public function findProductWithoutEventByCategory($agency, $category)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productEvents', 'pe')
            ->leftJoin('p.agency', 'a')
            ->leftJoin('p.productCategory', 'pc')
            ->where('pe.id is null')
            ->andWhere('a.id = :agency')
            ->andWhere('pc.id = :category')
            ->setParameter('agency', $agency)
            ->setParameter('category', $category)
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }

    // return product which no product

    // findProductEventByProductAndAgency
    public function findProductEventByProductAndAgency($product, $agency, $start, $end)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.productEvents', 'pe')
            ->leftJoin('p.agency', 'a')
            ->where('p.id = :product')
            ->andWhere('a.id = :agency')
            ->andWhere('pe.dateBegin BETWEEN :start AND :end')
            ->andWhere('pe.dateEnd BETWEEN :start AND :end')
            ->setParameter('product', $product)
            ->setParameter('agency', $agency)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('p.label', 'ASC');
        return $qb->getQuery()->getResult();
    }




    
}
