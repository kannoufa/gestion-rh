<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use App\Entity\DepartementService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DepartementService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartementService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartementService[]    findAll()
 * @method DepartementService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartementService::class);
    }

    /**
     * @return Query[]
     */
    public function findAllVisibleQuery(): Query
    {
        $query = $this->findVisibleQuery();
        $query = $query
            ->orderBy("p.nomFr", "ASC");

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}