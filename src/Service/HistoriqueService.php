<?php

namespace App\Service;

use App\Entity\Absence;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\OrdreMission;
use App\Form\AbsenceType;
use App\Form\AttestationSalaireType;
use App\Form\AttestationTravailType;
use App\Form\OrdreMissionType;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class HistoriqueService
{
    private $repo;
    private $paginator;

    public function __construct(HistoriqueRepository $repo, PaginatorInterface $paginator)
    {
        $this->repo = $repo;
        $this->paginator = $paginator;
    }

    public function getHistoryUser($id_user, $request)
    {
        $history = $this->paginator->paginate(
            $this->repo->findbyUserIdQuery($id_user),
            $request->query->getInt('page', 1),
            5
        );
        return $history;
    }
}