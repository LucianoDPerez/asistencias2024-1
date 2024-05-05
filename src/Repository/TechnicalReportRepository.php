<?php

namespace App\Repository;

use App\Entity\TechnicalReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnicalReport>
 *
 * @method TechnicalReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalReport[]    findAll()
 * @method TechnicalReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalReport::class);
    }

//    /**
//     * @return TechnicalReport[] Returns an array of TechnicalReport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TechnicalReport
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
