<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\OrdreMission;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(): Query
    {
        $query = $this->findVisibleQuery();
        $query = $query
            ->andWhere('p.statut <> :statut')
            ->setParameter('statut', 'reçu');

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
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