<?php

namespace App\Service;

use App\Entity\Absence;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\DepartementService;
use App\Entity\EnregistrementEntree;
use App\Entity\FicheRenseignement;
use App\Entity\Message;
use App\Entity\OrdreMission;
use App\Entity\Personnel;
use App\Form\AbsenceType;
use App\Form\AttestationSalaireType;
use App\Form\AttestationTravailType;
use App\Form\DepartementType;
use App\Form\EnregistrementEntreeType;
use App\Form\FicheRenseignementType;
use App\Form\OrdreMissionType;
use App\Form\PersonnelType;
use App\Repository\AbsenceRepository;
use App\Repository\OrdreMissionRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;

class FormService
{

    protected $entityManager;
    protected $repoAbsence;
    protected $repoOrdre;
    protected $personnelRepo;

    public function __construct(EntityManagerInterface $entityManager, PersonnelRepository $personnelRepo, AbsenceRepository $repoAbsence, OrdreMissionRepository $repoOrdre)
    {
        $this->entityManager = $entityManager;
        $this->repoAbsence = $repoAbsence;
        $this->repoOrdre = $repoOrdre;
        $this->personnelRepo = $personnelRepo;
    }

    public function getRepository($repo): array
    {
        if ($repo == 'AttestationSalaire') {
            $titre = 'Attestation de salaire';
            $document = new AttestationSalaire();
            $type = AttestationSalaireType::class;
        }

        if ($repo == 'AttestationTravail') {
            $titre = 'Attestation de travail';
            $document = new AttestationTravail();
            $type = AttestationTravailType::class;
        }

        if ($repo == 'Absence') {
            $titre = 'طلب رخصة أو إذن بالتغيب';
            $document = new Absence();
            $type = AbsenceType::class;
        }

        if ($repo == 'OrdreMission') {
            $titre = 'Ordre de mission';
            $document = new OrdreMission();
            $type = OrdreMissionType::class;
        }

        if ($repo == 'FicheRenseignement') {
            $titre = 'Fiche de renseignement';
            $document = new FicheRenseignement();
            $type = FicheRenseignementType::class;
        }

        if ($repo == 'EnregistrementEntree') {
            $titre = 'محضر الدخول';
            $document = new EnregistrementEntree();
            $type = EnregistrementEntreeType::class;
        }

        return [
            'type' => $type,
            'document' => $document,
            'titre' => $titre,
        ];
    }

    public function registerForm($document, $user, $repo, $tab): string
    {

        if ($repo == 'AttestationSalaire') {
            $message = 'Votre demande d\'attestation de salaire est envoyée avec succès ';
        }

        if ($repo == 'AttestationTravail') {
            $document->setNomFr($user->getPersonnel()->getNom())
                ->setPrenomFr($user->getPersonnel()->getPrenom())
                ->setPpr($user->getPersonnel()->getPpr())
                ->setCni($user->getPersonnel()->getCin())
                ->setGrade($user->getPersonnel()->getGradeAr())
                ->setDateFonction($user->getPersonnel()->getDateFonction());
            $message = 'Votre demande d\'attestation de travail est envoyée avec succès ';
        }

        if ($repo == 'Absence') {
            $document->setNomar($user->getPersonnel()->getNomAr())
                ->setPrenomar($user->getPersonnel()->getPrenomAr())
                ->setPpr($user->getPersonnel()->getPpr())
                ->setGrade($user->getPersonnel()->getGradeAr())
                ->setFiliere($user->getPersonnel()->getDepartementService()->getNomAr());
            $message = new Message();
            $message->setTitle('Demande validation : Absence');
            $message->setMessage($this->repoAbsence->findLastInserted()->getId() + 1);
            $message->setSender($user);
            $message->setRecipient($user->getPersonnel()->getDepartementService()->getChef());
            $message->setCreatedAt(new \DateTime());
            $this->entityManager->persist($message);
            $message = 'لقد تم اٍرسال طلبكم بنجاح';
        }

        if ($repo == 'OrdreMission') {
            $document = $this->Transport($document, $tab, $user->getUsername());
            $document->setNom($user->getPersonnel()->getNom())
                ->setPrenom($user->getPersonnel()->getPrenom());
            $message = new Message();
            $message->setTitle('Demande validation : Ordre de mission');
            $message->setMessage($this->repoOrdre->findLastInserted()->getId() + 1);
            $message->setSender($user);
            $message->setRecipient($user->getPersonnel()->getDepartementService()->getChef());
            $message->setCreatedAt(new \DateTime());
            $this->entityManager->persist($message);
            $message = 'Votre demande d\'ordre de mission est envoyée avec succès';
        }

        if ($repo == 'FicheRenseignement') {
            $document->setDoti($user->getPersonnel()->getPpr())
                ->setPrenom($user->getPersonnel()->getPrenom())
                ->setNom($user->getPersonnel()->getNom())
                ->setCin($user->getPersonnel()->getCin())
                ->setAdelectronique($user->getPersonnel()->getEmail())
                ->setDateNaiss($user->getPersonnel()->getDatenaissance())
                ->setFonction($user->getPersonnel()->getFonction());
            $message = 'votre fiche a été bien remplie !';
        }

        if ($repo == 'EnregistrementEntree') {
            $personnel = $this->personnelRepo->find($user); // dans user il y a l'id du personnel
            $document->setPersonnel($personnel)
                ->setNomAr($personnel->getNomAr())
                ->setPrenomAr($personnel->getPrenomAr())
                ->setNomFr($personnel->getNom())
                ->setPrenomFr($personnel->getPrenom())
                ->setDateNaissanceAr($personnel->getDatenaissance())
                ->setNationaliteAr($personnel->getNationaliteAr())
                ->setSituationFamilialeAr($personnel->getSituationFamilialeAr())
                ->setDateFonction($personnel->getDateFonction());
            $message = 'Les donées du PV ont été bien enregistrés';
        }

        $statut = 'Nouveau demande';
        if ($repo == 'OrdreMission' || $repo == 'Absence')
            $statut = 'En attante de validation par le département';

        if ($repo != 'EnregistrementEntree')
            $document->setPersonnel($user->getPersonnel());

        $document->setCreatedAt(new \DateTime())
            ->setStatut($statut);

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return $message;
    }

    public function
    Transport($document, $tab, $personnel)
    {
        $transport = $tab['transport'];
        $matricule = $tab['matricule'];

        if ($transport == 'Transport public') {
            $document->setTransport($transport)
                ->setChauffeur('');
        }
        if ($transport == 'Voiture personnel') {
            $document->setTransport($transport . ' - matricule: ' . $matricule)
                ->setChauffeur($personnel);
        }
        if ($transport == 'Transport universitaire') {
            $document->setTransport($transport)
                ->setChauffeur('');
        }

        return $document;
    }
}