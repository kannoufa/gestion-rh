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
            ->andWhere('p.statut <> :statut1')
            ->andWhere('p.statut <> :statut2')
            ->setParameter('statut1', 'reçu')
            ->setParameter('statut2', 'Refusé par l\'administration')
            ->orderBy("p.created_at", "DESC");

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    /**
     * @return Absence|null
     */
    public function findLastInserted()
    {
        return $this
            ->createQueryBuilder("p")
            ->orderBy("p.id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}