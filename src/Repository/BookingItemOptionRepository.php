<?php

namespace App\Repository;

use App\Entity\BookingItemOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookingItemOption>
 *
 * @method BookingItemOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingItemOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingItemOption[]    findAll()
 * @method BookingItemOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingItemOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingItemOption::class);
    }

//    /**
//     * @return BookingItemOption[] Returns an array of BookingItemOption objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BookingItemOption
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
