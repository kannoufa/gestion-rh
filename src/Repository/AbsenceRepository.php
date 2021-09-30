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
            ->andWhere('p.statut <> :statut3')
            ->andWhere('p.statut <> :statut4')
            ->andWhere('p.statut <> :statut5')
            ->setParameter('statut1', 'Reçu')
            ->setParameter('statut2', 'Refusé par l\'administration')
            ->setParameter('statut3', 'Refusé par le département')
            ->setParameter('statut4', 'En attante de validation par le département')
            ->setParameter('statut5', 'Refusé')
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
        $query = $this->findVisibleQuery()
            ->orderBy("p.apartir", "DESC")
            ->andWhere('p.statut = :statut')
            ->setParameter('statut', 'Reçu');

        if ($search->getPpr()) {
            $query = $query
                ->andWhere('p.ppr = :ppr')
                ->setParameter('ppr', $search->getPpr());
        }
        if ($search->getAnnee()) {
            $debAnnee = $search->getAnnee() . '-09-01'; #Y-m-d
            $finAnnee = (new \DateTime('01/01/' . $search->getAnnee()))->modify('+1 year')->format('Y') . '-07-31';
            $query = $query
                ->andWhere('p.apartir >= :debAnnee and p.apartir <= :finAnnee')
                ->setParameter('debAnnee', $debAnnee)
                ->setParameter('finAnnee', $finAnnee);
        } else {
            #par defaut 
            $now = new \DateTime('now');
            $start_year = new \DateTime('09/01/' . $now->format('Y')); #debut de septembre

            if ($now > $start_year)
                $year = $start_year->format('Y');
            else
                $year = $now->modify('-1 year')->format('Y');
            $debAnnee = $year . '-09-01'; #Y-m-d
            $finAnnee = (new \DateTime('01/01/' . $year))->modify('+1 year')->format('Y') . '-07-31';
            $query = $query
                ->andWhere('p.apartir >= :debAnnee and p.apartir <= :finAnnee')
                ->setParameter('debAnnee', $debAnnee)
                ->setParameter('finAnnee', $finAnnee);
        }

        return $query->getQuery();
    }
}