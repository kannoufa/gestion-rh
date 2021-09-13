<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Personnel;
use App\Entity\PersonnelSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Personnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnel[]    findAll()
 * @method Personnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnel::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(PersonnelSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getPpr()) {
            $query = $query
                ->andWhere('p.ppr = :ppr')
                ->setParameter('ppr', $search->getPpr())
                ->orderBy("p.nom", "ASC");
        }

        if ($search->getNom()) {
            $query = $query
                ->andWhere('p.nom = :val')
                ->setParameter('val', $search->getNom());
        }

        if ($search->getPrenom()) {
            $query = $query
                ->andWhere('p.prenom = :val')
                ->setParameter('val', $search->getPrenom());
        }

        if ($search->getFonction()) {
            $query = $query
                ->andWhere('p.fonction = :val')
                ->setParameter('val', $search->getFonction());
        }

        if ($search->getGrade()) {
            $query = $query
                ->andWhere('p.grade_ar = :val')
                ->setParameter('val', $search->getGrade());
        }

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    /**
     * @return Personnel|null
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