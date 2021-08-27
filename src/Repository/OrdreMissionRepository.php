<?php

namespace App\Repository;

use App\Entity\OrdreMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdreMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdreMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdreMission[]    findAll()
 * @method OrdreMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdreMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdreMission::class);
    }

    // /**
    //  * @return OrdreMission[] Returns an array of OrdreMission objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdreMission
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
