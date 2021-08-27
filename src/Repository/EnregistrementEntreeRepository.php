<?php

namespace App\Repository;

use App\Entity\EnregitrementEntree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnregitrementEntree|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnregitrementEntree|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnregitrementEntree[]    findAll()
 * @method EnregitrementEntree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnregitrementEntreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnregitrementEntree::class);
    }

    // /**
    //  * @return EnregitrementEntree[] Returns an array of EnregitrementEntree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnregitrementEntree
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
