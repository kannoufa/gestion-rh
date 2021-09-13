<?php

namespace App\Service;

use DateTime;
use App\Entity\Message;
use App\Entity\Historique;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrdreMissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\AttestationSalaireRepository;
use App\Repository\AttestationTravailRepository;
use App\Repository\DepartementServiceRepository;
use App\Repository\FicheRenseignementRepository;
use App\Repository\EnregistrementEntreeRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StatutService
{

    protected $enregistrementEtreeRepository;
    protected $attestationTravailRepository;
    protected $attestationSalaireRepository;
    protected $ficheRenseignementRepository;
    protected $ordreMissionRepository;
    protected $personnelRepository;
    protected $historiqueRepository;
    protected $absenceRepository;
    protected $paginator;
    protected $entityManager;
    protected $router;
    protected $departementRepository;



    public function __construct(DepartementServiceRepository $departementRepository, UrlGeneratorInterface $router, EntityManagerInterface $entityManager, PersonnelRepository $personnelRepository, AttestationTravailRepository $attestationTravailRepository, OrdreMissionRepository $ordreMissionRepository, AttestationSalaireRepository $attestationSalaireRepository, AbsenceRepository $absenceRepository, PaginatorInterface $paginator, FicheRenseignementRepository $ficheRenseignementRepository, HistoriqueRepository $historiqueRepository, EnregistrementEntreeRepository $enregistrementEtreeRepository)
    {
        $this->enregistrementEtreeRepository = $enregistrementEtreeRepository;
        $this->attestationTravailRepository = $attestationTravailRepository;
        $this->attestationSalaireRepository = $attestationSalaireRepository;
        $this->ficheRenseignementRepository = $ficheRenseignementRepository;
        $this->ordreMissionRepository = $ordreMissionRepository;
        $this->personnelRepository = $personnelRepository;
        $this->historiqueRepository = $historiqueRepository;
        $this->absenceRepository = $absenceRepository;
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->router = $router;
        $this->departementRepository = $departementRepository;
    }

    public function getRepository($repo)
    {
        $twig_validation = '';
        if ($repo == 'AttestationTravail') {
            $repository = $this->attestationTravailRepository;
            $twig_document = 'admin/attestation_travail.html.twig';
            $twig_liste_document = 'admin/attestations_travail.html.twig';
        }
        if ($repo == 'AttestationSalaire') {
            $repository = $this->attestationSalaireRepository;
            $twig_document = 'admin/attestation_salaire.html.twig';
            $twig_liste_document = 'admin/attestations_salaire.html.twig';
        }
        if ($repo == 'Absence') {
            $repository = $this->absenceRepository;
            $twig_document = 'admin/absence.html.twig';
            $twig_validation = 'user/validation_absence.html.twig';
            $twig_liste_document = 'admin/absences.html.twig';
        }
        if ($repo == 'OrdreMission') {
            $repository = $this->ordreMissionRepository;
            $twig_document = 'admin/ordre.html.twig';
            $twig_validation = 'user/validation_ordre.html.twig';
            $twig_liste_document = 'admin/ordres.html.twig';
        }
        if ($repo == 'FicheRenseignement') {
            $repository = $this->ficheRenseignementRepository;
            $twig_document = 'admin/fiche.html.twig';
            $twig_liste_document = 'admin/fiches.html.twig';
        }
        if ($repo == 'EnregistrementEntree') {
            $repository = $this->enregistrementEtreeRepository;
            $twig_document = 'admin/entree.html.twig';
            $twig_liste_document = 'admin/entrees.html.twig';
        }
        if ($repo == 'Historique') {
            $repository = $this->historiqueRepository;
            $twig_document = 'admin/historique.html.twig';
            $twig_liste_document = 'admin/historique.html.twig';
        }
        if ($repo == 'Departement') {
            $repository = $this->departementRepository;
            $twig_document = '';
            $twig_liste_document = 'admin/liste_departement.html.twig';
        }
        if ($repo == 'Personnel') {
            $repository = $this->personnelRepository;
            $twig_document = 'admin/profil.html.twig';
            $twig_liste_document = 'admin/liste_personnels.html.twig';
        }

        return [
            'repository' => $repository,
            'twig_document' => $twig_document,
            'twig_liste_document' => $twig_liste_document,
            'twig_validation' => $twig_validation
        ];
    }

    public function changeStatut($repo, $id, $etat)
    {
        if ($repo != 'Personnel') {
            $document = $this->getRepository($repo)['repository']->find($id);
            if ($etat == 'Voir') {
                $statut = $document->getStatut();
                if ($statut == 'Nouveau demande' || $statut == 'Validé par le département')
                    $statut = 'en cours de traitement';
            }

            if ($etat == 'Disponible') {
                $statut = 'Disponible';
            }
            if ($etat == 'Validé par le département') {
                $statut = 'Validé par le département';
            }
            if ($etat == 'Refusé par le département') {
                $statut = 'Refusé par le département';
            }
            if ($etat == 'Refusé par l\'administration') {
                $statut = 'Refusé par l\'administration';
                // Si la demande est Refusé par l'administration on l'enregistre dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($id)
                    ->setIdUser($document->getPersonnel()->getId())
                    ->setNomPrenom($document->getPersonnel()->getNom() . ' ' . $document->getPersonnel()->getPrenom())
                    ->setTypeDemande($repo)
                    ->setDateEnvoi($document->getCreatedAt())
                    ->setDateRecu(new DateTime())
                    ->setStatut('Refusé');
                $this->entityManager->persist($historique);
                $this->entityManager->flush();
            }
            if ($etat == 'Reçu') {
                $statut = 'Reçu';
                // Si la demande est reçu par le fonctionnaire on l'enregistre dans l'historique
                $historique = new Historique();
                $historique->setIdDemande($id)
                    ->setIdUser($document->getPersonnel()->getId())
                    ->setNomPrenom($document->getPersonnel()->getNom() . ' ' . $document->getPersonnel()->getPrenom())
                    ->setTypeDemande($repo)
                    ->setDateEnvoi($document->getCreatedAt())
                    ->setDateRecu(new DateTime())
                    ->setStatut('Reçu');
                $this->entityManager->persist($historique);
                $this->entityManager->flush();
            }
            $document->setStatut($statut);
            $this->entityManager->persist($document);
            $this->entityManager->flush();
        }
        return $this->getRepository($repo);
    }

    public function getDocument($repo, $id)
    {
        $repository = $this->changeStatut($repo, $id, 'Voir')['repository'];
        if ($repo == 'FicheRenseignement')
            $document = $document = $repository->findOneBy([
                'personnel' => $id,
            ]);
        else
            $document = $repository->find($id);
        return $document;
    }

    public function getListeDocuments($repo, $request, $search)
    {
        if ($repo != null && $repo != 'Personnel') {
            $documents = $this->paginator->paginate(
                $this->getRepository($repo)['repository']->findAllVisibleQuery(),
                $request->query->getInt('page', 1),
                8
            );
            $twig = $this->getRepository($repo)['twig_liste_document'];
        } elseif ($repo == 'Personnel') {
            $documents = $this->paginator->paginate(
                $this->personnelRepository->findAllVisibleQuery($search),
                $request->query->getInt('page', 1),
                8
            );
            $twig = $this->getRepository($repo)['twig_liste_document'];
        } else {
            $documents = $this->paginator->paginate(
                $this->absenceRepository->findAbsenceRecu($search),
                $request->query->getInt('page', 1),
                10
            );
            $twig = "admin/tab_absence.html.twig";
        }


        return [
            'twig' => $twig,
            'documents' => $documents
        ];
    }
}