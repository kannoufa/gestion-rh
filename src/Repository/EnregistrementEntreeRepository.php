<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Entity\EnregistrementEntree;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method EnregistrementEntree|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnregistrementEntree|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnregistrementEntree[]    findAll()
 * @method EnregistrementEntree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnregistrementEntreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnregistrementEntree::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
            ->orderBy("p.created_at", "DESC")
            ->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}