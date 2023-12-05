<?php

namespace App\Repository;

use App\Entity\CalendarDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalendarDay>
 *
 * @method CalendarDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarDay[]    findAll()
 * @method CalendarDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarDay::class);
    }

//    /**
//     * @return CalendarDay[] Returns an array of CalendarDay objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CalendarDay
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
