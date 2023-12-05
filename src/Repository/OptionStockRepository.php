<?php

namespace App\Repository;

use App\Entity\OptionStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OptionStock>
 *
 * @method OptionStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionStock[]    findAll()
 * @method OptionStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionStock::class);
    }

//    /**
//     * @return OptionStock[] Returns an array of OptionStock objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OptionStock
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
