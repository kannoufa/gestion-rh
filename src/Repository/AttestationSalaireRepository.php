<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Entity\AttestationSalaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method AttestationSalaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationSalaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationSalaire[]    findAll()
 * @method AttestationSalaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationSalaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationSalaire::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(): Query
    {
        $query = $this->findVisibleQuery();
        $query = $query
            ->andWhere('p.statut <> :statut1')
            ->setParameter('statut1', 'Reçu')
            ->orderBy("p.created_at", "DESC");

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}