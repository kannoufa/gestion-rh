<?php

namespace App\Service;

use App\Entity\Message;
use App\Entity\AttestationSalaire;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrdreMissionRepository;

class FormService
{
    protected $entityManager;
    protected $repoAbsence;
    protected $repoOrdre;

    public function __construct(EntityManagerInterface $entityManager, AbsenceRepository $repoAbsence, OrdreMissionRepository $repoOrdre)
    {
        $this->entityManager = $entityManager;
        $this->repoAbsence = $repoAbsence;
        $this->repoOrdre = $repoOrdre;
    }


    /**
     * enregistrer la demande dans le base de données
     */
    public function registerForm($document, $user, $repo, $tab = null): string
    {
        if ($repo == 'AttestationSalaire') {
            $document = $this->Type($document, $tab);
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
            $this->entityManager->persist($message);
            $message = 'لقد تم اٍرسال طلبكم بنجاح';
        }
        if ($repo == 'OrdreMission') {
            $document->setNom($user->getPersonnel()->getNom())
                ->setPrenom($user->getPersonnel()->getPrenom());
            $document = $this->Transport($document, $tab);
            $message = new Message();
            $message->setTitle('Demande validation : Ordre de mission');
            $message->setMessage($this->repoOrdre->findLastInserted()->getId() + 1);
            $message->setSender($user);
            $message->setRecipient($user->getPersonnel()->getDepartementService()->getChef());
            $this->entityManager->persist($message);
            $message = 'Votre demande d\'ordre de mission est envoyée avec succès';
        }
        $statut = 'Nouvelle demande';
        if ($repo == 'OrdreMission' || $repo == 'Absence')
            $statut = 'En attante de validation par le département';

        $document->setPersonnel($user->getPersonnel())->setStatut($statut);
        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return $message;
    }

    /**
     * modifier le transport de l'ordre de mission
     */
    public function Transport($document, $tab)
    {
        $transport = $tab['transport'];
        $matricule = $tab['matricule'];

        if ($transport == 'Véhicule personnel') {
            $document->setTransport($transport . ' - matricule: ' . $matricule)
                ->setChauffeur($document->getNom() . ' ' . $document->getPrenom());
        } else
            $document->setTransport($transport)->setChauffeur('');
        return $document;
    }

    /**
     * modifier le type de l'att. de salaire (mois/trimestre/année)
     */
    public function Type($document, $tab)
    {
        $autre = $tab['autre'];

        if ($autre != null)
            $document->setType($autre);
        else
            $document->setType(AttestationSalaire::TYPE[$tab['type']]);
        return $document;
    }
}