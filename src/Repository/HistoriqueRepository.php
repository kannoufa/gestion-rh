<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Historique;
use App\Entity\HistoriqueSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Historique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historique[]    findAll()
 * @method Historique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historique::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(HistoriqueSearch $search): Query
    {
        $query = $this->findVisibleQuery()
            ->orderBy("p.dateRecu", "DESC");

        if ($search->getPpr()) {
            $query = $query
                ->andWhere('p.ppr = :ppr')
                ->setParameter('ppr', $search->getPpr());
        }

        if ($search->getTypeDemande()) {
            $query = $query
                ->andWhere('p.typeDemande = :val')
                ->setParameter('val', $search->getTypeDemande());
        }

        return $query->getQuery();
    }

    /**
     * @return Query[]
     */
    public function findbyUserIdQuery($id): Query
    {
        $query = $this->findVisibleQuery();
        $query = $query
            ->andWhere('p.idUser = :id')
            ->setParameter('id', $id)
            ->orderBy("p.dateRecu", "DESC");

        return $query->getQuery();
    }
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}