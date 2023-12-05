<?php

namespace App\Repository;

use App\Entity\VehicleDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleDocument>
 *
 * @method VehicleDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleDocument[]    findAll()
 * @method VehicleDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleDocument::class);
    }

//    /**
//     * @return VehicleDocument[] Returns an array of VehicleDocument objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VehicleDocument
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
