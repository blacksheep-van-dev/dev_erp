<?php

namespace App\Repository;

use App\Entity\StockOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockOption>
 *
 * @method StockOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockOption[]    findAll()
 * @method StockOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockOption::class);
    }

//    /**
//     * @return StockOption[] Returns an array of StockOption objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StockOption
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
