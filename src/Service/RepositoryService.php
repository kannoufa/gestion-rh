<?php

namespace App\Service;

use App\Entity\Absence;
use App\Entity\Vehicule;
use App\Entity\Chauffeur;
use App\Form\AbsenceType;
use App\Form\VehiculeType;
use App\Form\ChauffeurType;
use App\Entity\OrdreMission;
use App\Form\DepartementType;
use App\Form\OrdreMissionType;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\DepartementService;
use App\Form\AttestationSalaireType;
use App\Form\AttestationTravailType;
use App\Repository\AbsenceRepository;
use App\Repository\VehiculeRepository;
use App\Repository\ChauffeurRepository;
use App\Repository\PersonnelRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\OrdreMissionRepository;
use App\Repository\AttestationSalaireRepository;
use App\Repository\AttestationTravailRepository;
use App\Repository\DepartementServiceRepository;

class RepositoryService
{
    protected $attestationTravailRepository;
    protected $attestationSalaireRepository;
    protected $ordreMissionRepository;
    protected $departementRepository;
    protected $historiqueRepository;
    protected $personnelRepository;
    protected $chauffeurRepository;
    protected $vehiculeRepository;
    protected $absenceRepository;

    public function __construct(VehiculeRepository $vehiculeRepository, ChauffeurRepository $chauffeurRepository, DepartementServiceRepository $departementRepository, PersonnelRepository $personnelRepository, AttestationTravailRepository $attestationTravailRepository, OrdreMissionRepository $ordreMissionRepository, AttestationSalaireRepository $attestationSalaireRepository, AbsenceRepository $absenceRepository, HistoriqueRepository $historiqueRepository)
    {
        $this->attestationTravailRepository = $attestationTravailRepository;
        $this->attestationSalaireRepository = $attestationSalaireRepository;
        $this->ordreMissionRepository       = $ordreMissionRepository;
        $this->departementRepository        = $departementRepository;
        $this->historiqueRepository         = $historiqueRepository;
        $this->personnelRepository          = $personnelRepository;
        $this->chauffeurRepository          = $chauffeurRepository;
        $this->vehiculeRepository           = $vehiculeRepository;
        $this->absenceRepository            = $absenceRepository;
    }

    public function getRepository($repo)
    {
        $twig_document = $document = $type = $titre = $twig_validation = $twig_liste_document = null;
        if ($repo == 'AttestationTravail') {
            $repository             = $this->attestationTravailRepository;
            $twig_document          = 'admin/attestationTravail/attestation_travail.html.twig';
            $twig_liste_document    = 'admin/attestationTravail/attestations_travail.html.twig';
            $titre                  = 'Attestation de travail';
            $document               = new AttestationTravail();
            $type                   = AttestationTravailType::class;
        }
        if ($repo == 'AttestationSalaire') {
            $repository             = $this->attestationSalaireRepository;
            $twig_liste_document    = 'admin/attestationSalaire/attestations_salaire.html.twig';
            $titre                  = 'Attestation de salaire';
            $document               = new AttestationSalaire();
            $type                   = AttestationSalaireType::class;
        }
        if ($repo == 'Absence') {
            $repository = $this->absenceRepository;
            $twig_document          = 'admin/absence/absence.html.twig';
            $twig_validation        = 'user/validation/validation_absence.html.twig';
            $twig_liste_document    = 'admin/absence/absences.html.twig';
            $titre                  = 'طلب رخصة أو إذن بالتغيب';
            $document               = new Absence();
            $type                   = AbsenceType::class;
        }
        if ($repo == 'OrdreMission') {
            $repository             = $this->ordreMissionRepository;
            $twig_document          = 'admin/ordre/ordre.html.twig';
            $twig_validation        = 'user/validation/validation_ordre.html.twig';
            $twig_liste_document    = 'admin/ordre/ordres.html.twig';
            $titre                  = 'Ordre de mission';
            $document               = new OrdreMission();
            $type                   = OrdreMissionType::class;
        }
        if ($repo == 'Historique') {
            $repository             = $this->historiqueRepository;
            $twig_liste_document    = 'admin/historique.html.twig';
        }
        if ($repo == 'Departement') {
            $repository             = $this->departementRepository;
            $twig_liste_document    = 'admin/parametres/liste_departement.html.twig';
            $type                   = DepartementType::class;
            $titre                  = 'ajout d\'un département ou service';
            $document               = new DepartementService();
        }
        if ($repo == 'Vehicule') {
            $repository             = $this->vehiculeRepository;
            $twig_liste_document    = 'admin/parametres/liste_vehicule.html.twig';
            $type                   = VehiculeType::class;
            $titre                  = 'ajout d\'un véhicule';
            $document               = new Vehicule();
        }
        if ($repo == 'Chauffeur') {
            $repository             = $this->chauffeurRepository;
            $twig_liste_document    = 'admin/parametres/liste_chauffeur.html.twig';
            $type                   = ChauffeurType::class;
            $titre                  = 'ajout d\'un chaffeur';
            $document               = new Chauffeur();
        }
        if ($repo == 'Personnel') {
            $repository             = $this->personnelRepository;
            $twig_document          = 'admin/personnel/profil.html.twig';
            $twig_liste_document    = 'admin/personnel/liste_personnels.html.twig';
        }

        if ($repo == 'FicheRenseignement') {
            $repository             = $this->personnelRepository;
            $twig_document          = 'admin/personnel/fiche.html.twig';
        }

        return [
            'repository' => $repository,
            'twig_document' => $twig_document,
            'twig_liste_document' => $twig_liste_document,
            'twig_validation' => $twig_validation,
            'type' => $type,
            'document' => $document,
            'titre' => $titre,
        ];
    }
}