<?php

namespace App\Repository;

use App\Entity\Absence;
use App\Entity\AbsenceSearch;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
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
            ->setParameter('statut1', 'Reçu')
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

    /**
     * @return Query[]
     */
    public function findAbsenceRecu(AbsenceSearch $search): Query
    {
        $query = $this->findVisibleQuery();
        if ($search->getPpr()) {
            $query = $query
                ->andWhere('p.ppr = :ppr')
                ->andWhere('p.statut = :statut')
                ->setParameter('statut', 'Reçu')
                ->setParameter('ppr', $search->getPpr())
                ->orderBy("p.created_at", "DESC");
        }

        return $query->getQuery();
    }
}