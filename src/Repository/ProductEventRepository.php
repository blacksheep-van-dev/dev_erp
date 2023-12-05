<?php

namespace App\Repository;

use App\Entity\ProductEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductEvent>
 *
 * @method ProductEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductEvent[]    findAll()
 * @method ProductEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEvent::class);
    }

//    /**
//     * @return ProductEvent[] Returns an array of ProductEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductEvent
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
