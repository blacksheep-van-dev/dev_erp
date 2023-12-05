<?php

namespace App\Repository;

use App\Entity\CalendarClosedDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalendarClosedDays>
 *
 * @method CalendarClosedDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarClosedDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarClosedDays[]    findAll()
 * @method CalendarClosedDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarClosedDaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarClosedDays::class);
    }

//    /**
//     * @return CalendarClosedDays[] Returns an array of CalendarClosedDays objects
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

//    public function findOneBySomeField($value): ?CalendarClosedDays
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
