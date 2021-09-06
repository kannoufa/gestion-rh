<?php

namespace App\Service;

use App\Entity\Absence;
use App\Entity\AttestationSalaire;
use App\Entity\AttestationTravail;
use App\Entity\OrdreMission;
use App\Entity\Personnel;
use App\Form\AbsenceType;
use App\Form\AttestationSalaireType;
use App\Form\AttestationTravailType;
use App\Form\OrdreMissionType;
use App\Form\PersonnelType;
use Doctrine\ORM\EntityManagerInterface;

class FormService
{

    protected $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            $titre = 'طلب رخصة أو الإذن بالتغيب';
            $document = new Absence();
            $type = AbsenceType::class;
        }

        if ($repo == 'OrdreMission') {
            $titre = 'Ordre de mission';
            $document = new OrdreMission();
            $type = OrdreMissionType::class;
        }

        return [
            'type' => $type,
            'document' => $document,
            'titre' => $titre,
        ];
    }

    public function registerForm($document, $user, $repo): string
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
                ->setGrade($user->getPersonnel()->getGradeAr());
            $message = 'لقد تم اٍرسال طلبكم بنجاح';
        }

        if ($repo == 'OrdreMission') {
            $document->setNom($user->getPersonnel()->getNom())
                ->setPrenom($user->getPersonnel()->getPrenom());
            $message = 'Votre demande d\'ordre de mission est envoyée avec succès ';
        }

        $document->setPersonnel($user->getPersonnel())
            ->setCreatedAt(new \DateTime())
            ->setStatut('Nouveau demande');


        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return $message;
    }
}