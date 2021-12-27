<?php

namespace App\Service;

use DateTime;
use App\Entity\Historique;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class DocumentService
{

    protected $personnelRepository;
    protected $absenceRepository;
    protected $entityManager;
    protected $repoService;
    protected $paginator;

    public function __construct(RepositoryService $repoService, EntityManagerInterface $entityManager, PersonnelRepository $personnelRepository, AbsenceRepository $absenceRepository, PaginatorInterface $paginator)
    {
        $this->personnelRepository          = $personnelRepository;
        $this->absenceRepository            = $absenceRepository;
        $this->entityManager                = $entityManager;
        $this->repoService                  = $repoService;
        $this->paginator                    = $paginator;
    }


    /**
     * Changer le statut de la demande
     */
    public function changeStatut($repo, $id, $etat)
    {
        $array = $this->repoService->getRepository($repo);
        if ($repo != 'Personnel') {
            $document = $array['repository']->find($id);

            if ($etat == 'Voir') {
                $statut = $document->getStatut();
                if ($statut == 'Nouvelle demande' || $statut == 'Validé par le département')
                    $statut = 'en cours de traitement';
            } elseif ($etat == 'Reçu') {
                $statut = 'Reçu';
                // Si la demande est reçu par le fonctionnaire on l'enregistre dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($id)
                    ->setIdUser($document->getPersonnel()->getId())
                    ->setNomPrenom($document->getPersonnel()->getNom() . ' ' . $document->getPersonnel()->getPrenom())
                    ->setPpr($document->getPersonnel()->getPpr())
                    ->setTypeDemande($repo)
                    ->setDateEnvoi($document->getCreatedAt())
                    ->setDateRecu(new DateTime());
                $this->entityManager->persist($historique);
            } else {
                $statut = $etat;
            }
            $document->setStatut($statut);
            $this->entityManager->persist($document);
            $this->entityManager->flush();
        }
        return $array;
    }


    /**
     * retourne la liste des demande
     */
    public function getListeDocuments($repo = null, $request, $search = null)
    {
        if ($repo != null) {
            $repository = $this->repoService->getRepository($repo)['repository'];
            if ($search)
                $documents = $this->paginator->paginate(
                    $repository->findAllVisibleQuery($search),
                    $request->query->getInt('page', 1),
                    4
                );
            else
                $documents = $this->paginator->paginate(
                    $repository->findAllVisibleQuery(),
                    $request->query->getInt('page', 1),
                    4
                );
            $twig = $this->repoService->getRepository($repo)['twig_liste_document'];
        } else {
            $documents = $this->paginator->paginate(
                $this->absenceRepository->findAbsenceRecu($search),
                $request->query->getInt('page', 1),
                4
            );
            $twig = "admin/absence/tab_absence.html.twig";
        }

        return [
            'twig' => $twig,
            'documents' => $documents
        ];
    }


    /**
     * retourne une demande à partir de son id et du repo,
     * dans le cas du fiche : on retourne le personnel car tous les infos sont dans la table personnel
     */
    public function getDocument($repo, $id)
    {
        if ($repo == 'FicheRenseignement')
            $document = $this->personnelRepository->find($id);
        else
            $document = $this->changeStatut($repo, $id, 'Voir')['repository']->find($id);
        return $document;
    }
}