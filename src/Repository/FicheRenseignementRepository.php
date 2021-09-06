<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Entity\FicheRenseignement;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method FicheRenseignement|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheRenseignement|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheRenseignement[]    findAll()
 * @method FicheRenseignement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRenseignementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheRenseignement::class);
    }

    /**
    * @return Query[]
    */
    public function findAllVisibleQuery() : Query
    {
        return $this->findVisibleQuery()
            ->getQuery()
        ;
    }

    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    // /**
    //  * @return FicheRenseignement[] Returns an array of FicheRenseignement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FicheRenseignement
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}