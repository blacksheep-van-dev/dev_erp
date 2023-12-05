<?php

namespace App\Repository;

use App\Entity\CalendarHour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalendarHour>
 *
 * @method CalendarHour|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarHour|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarHour[]    findAll()
 * @method CalendarHour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarHourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarHour::class);
    }

//    /**
//     * @return CalendarHour[] Returns an array of CalendarHour objects
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

//    public function findOneBySomeField($value): ?CalendarHour
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
