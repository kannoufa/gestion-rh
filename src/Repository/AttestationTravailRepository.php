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
            ->setParameter('statut', 'reçu');

        return $query->getQuery();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    /**
     * @return Attestationtravail[]
     */
    public function getAttestationtravailUnready(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Attestationtravail a
            WHERE a.status <> :status'
        )->setParameter('status', 'reçu');

        return $query->getResult();
    }

    // /**
    //  * @return AttestationTravail[] Returns an array of AttestationTravail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttestationTravail
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}