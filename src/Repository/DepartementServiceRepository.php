<?php

namespace App\Repository;

use App\Entity\DepartementService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepartementService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartementService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartementService[]    findAll()
 * @method DepartementService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartementService::class);
    }

    // /**
    //  * @return DepartementService[] Returns an array of DepartementService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepartementService
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
