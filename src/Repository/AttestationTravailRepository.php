<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Entity\AttestationTravail;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method AttestationTravail|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationTravail|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationTravail[]    findAll()
 * @method AttestationTravail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationTravailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationTravail::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(): Query
    {
        $query = $this->findVisibleQuery();
        $query = $query
            ->andWhere('p.statut <> :statut')
            ->setParameter('statut', 'Reçu')
            ->orderBy("p.created_at", "DESC");

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}