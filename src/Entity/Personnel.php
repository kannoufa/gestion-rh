<?php

namespace App\Entity;

use App\Entity\Absence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PersonnelRepository::class)
 * @UniqueEntity(
 *     fields={"ppr"},
 *     message="Ce numéro P.P.R existe déjà"
 * )
 * @Vich\Uploadable()
 */
class Personnel
{
    const SEXEAR = [
        0 => 'أنثى',
        1 => 'ذكر',
    ];

    const SEXE = [
        0 => 'féminin',
        1 => 'masculin',
    ];

    const SITUATIONFAMILIAIREAR = [
        0 => 'اعزب/عزباء',
        1 => '(ة)متزوج',
        2 => '(ة)مطلق',
        3 => '(ة)أرمل',
    ];

    const ETATCIVIL = [
        0 => 'Célibataire',
        1 => 'Marié(e)',
        2 => 'Divorcé(e)',
        3 => 'Veuf/Veuve',
    ];


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="personnel", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Absence::class, mappedBy="personnel")
     */
    private $absences;

    /**
     * @ORM\OneToMany(targetEntity=AttestationSalaire::class, mappedBy="personnel")
     */
    private $attestations_salaire;

    /**
     * @ORM\OneToMany(targetEntity=AttestationTravail::class, mappedBy="personnel")
     */
    private $attestations_travail;

    /**
     * @ORM\OneToMany(targetEntity=OrdreMission::class, mappedBy="personnel")
     */
    private $ordres;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]{7}$/",
     *     message="le P.P.R doit contenir 7 chiffres"
     * )
     */
    private $ppr;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_ar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom_ar;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_recrutement;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $sexe_ar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nationalite_ar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nationalite;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $echellon;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_effet_echelon;


    /**
     * @ORM\ManyToOne(targetEntity=DepartementService::class, inversedBy="chef")
     */
    private $departementService;

    /**
     * @ORM\Column(type="integer")
     */
    private $anciennete_echelon;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $grade_ar;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_effet_grade;

    /**
     * @ORM\Column(type="integer")
     */
    private $anciennete_grade;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $situation_administrative_ar;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fonction;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_fonction;

    /**
     * @ORM\Column(type="integer")
     */
    private $anciennete_administrative;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $etablissement_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situation_familiale_ar;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieunaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatcivil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $situationconj;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doticonj;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrenfant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $echelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diplome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adpersonnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $advacance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephonne;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(
     *      mimeTypes="image/jpeg")
     * @Vich\UploadableField(mapping="personnel_image", fileNameProperty="filename")
     */
    private $imageFile;



    public function __construct()
    {
        $this->absences = new ArrayCollection();
        $this->attestations_salaire = new ArrayCollection();
        $this->attestations_travail = new ArrayCollection();
        $this->ordres = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPpr(): ?string
    {
        return $this->ppr;
    }

    public function setPpr(?string $ppr): self
    {
        $this->ppr = $ppr;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNomAr(): ?string
    {
        return $this->nom_ar;
    }

    public function setNomAr(?string $nom_ar): self
    {
        $this->nom_ar = $nom_ar;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPrenomAr(): ?string
    {
        return $this->prenom_ar;
    }

    public function setPrenomAr(?string $prenom_ar): self
    {
        $this->prenom_ar = $prenom_ar;

        return $this;
    }

    public function getDepartementService(): ?DepartementService
    {
        return $this->departementService;
    }

    public function setDepartementService(?DepartementService $departementService): self
    {
        $this->departementService = $departementService;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTime $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateRecrutement(): ?\DateTime
    {
        return $this->date_recrutement;
    }

    public function setDateRecrutement(?\DateTime $date_recrutement): self
    {
        $this->date_recrutement = $date_recrutement;

        return $this;
    }

    public function getSexeAr(): ?string
    {
        return $this->sexe_ar;
    }

    public function setSexeAr(?string $sexe_ar): self
    {
        $this->sexe_ar = $sexe_ar;

        return $this;
    }

    public function getNationaliteAr(): ?string
    {
        return $this->nationalite_ar;
    }

    public function setNationaliteAr(?string $nationalite_ar): self
    {
        $this->nationalite_ar = $nationalite_ar;

        return $this;
    }

    public function getEchellon(): ?string
    {
        return $this->echellon;
    }

    public function setEchellon(?string $echellon): self
    {
        $this->echellon = $echellon;

        return $this;
    }

    public function getDateEffetEchelon(): ?\DateTime
    {
        return $this->date_effet_echelon;
    }

    public function setDateEffetEchelon(?\DateTime $date_effet_echelon): self
    {
        $this->date_effet_echelon = $date_effet_echelon;

        return $this;
    }

    public function getAncienneteEchelon(): ?int
    {
        return $this->anciennete_echelon;
    }

    public function setAncienneteEchelon(?int $anciennete_echelon): self
    {
        $this->anciennete_echelon = $anciennete_echelon;

        return $this;
    }

    public function getGradeAr(): ?string
    {
        return $this->grade_ar;
    }

    public function setGradeAr(?string $grade_ar): self
    {
        $this->grade_ar = $grade_ar;

        return $this;
    }

    public function getDateEffetGrade(): ?\DateTime
    {
        return $this->date_effet_grade;
    }

    public function setDateEffetGrade(?\DateTime $date_effet_grade): self
    {
        $this->date_effet_grade = $date_effet_grade;

        return $this;
    }

    public function getAncienneteGrade(): ?int
    {
        return $this->anciennete_grade;
    }

    public function setAncienneteGrade(?int $anciennete_grade): self
    {
        $this->anciennete_grade = $anciennete_grade;

        return $this;
    }

    public function getSituationAdministrativeAr(): ?string
    {
        return $this->situation_administrative_ar;
    }

    public function setSituationAdministrativeAr(?string $situation_administrative_ar): self
    {
        $this->situation_administrative_ar = $situation_administrative_ar;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDateFonction(): ?\DateTime
    {
        return $this->date_fonction;
    }

    public function setDateFonction(?\DateTime $date_fonction): self
    {
        $this->date_fonction = $date_fonction;

        return $this;
    }

    public function getAncienneteAdministrative(): ?int
    {
        return $this->anciennete_administrative;
    }

    public function setAncienneteAdministrative(?int $anciennete_administrative): self
    {
        $this->anciennete_administrative = $anciennete_administrative;

        return $this;
    }

    public function getEtablissementAr(): ?string
    {
        return $this->etablissement_ar;
    }

    public function setEtablissementAr(?string $etablissement_ar): self
    {
        $this->etablissement_ar = $etablissement_ar;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDatePosition(): ?\DateTime
    {
        return $this->date_position;
    }

    public function setDatePosition(?\DateTime $date_position): self
    {
        $this->date_position = $date_position;

        return $this;
    }

    public function getSituationFamilialeAr(): ?string
    {
        return $this->situation_familiale_ar;
    }

    public function setSituationFamilialeAr(?string $situation_familiale_ar): self
    {
        $this->situation_familiale_ar = $situation_familiale_ar;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getLieunaiss(): ?string
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getEtatcivil(): ?string
    {
        return $this->etatcivil;
    }

    public function setEtatcivil(string $etatcivil): self
    {
        $this->etatcivil = $etatcivil;

        return $this;
    }

    public function getSituationconj(): ?string
    {
        return $this->situationconj;
    }

    public function setSituationconj(?string $situationconj): self
    {
        $this->situationconj = $situationconj;

        return $this;
    }

    public function getDoticonj(): ?string
    {
        return $this->doticonj;
    }

    public function setDoticonj(?string $doticonj): self
    {
        $this->doticonj = $doticonj;

        return $this;
    }

    public function getNbrenfant(): ?string
    {
        return $this->nbrenfant;
    }

    public function setNbrenfant(?string $nbrenfant): self
    {
        $this->nbrenfant = $nbrenfant;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getEchelle(): ?string
    {
        return $this->echelle;
    }

    public function setEchelle(string $echelle): self
    {
        $this->echelle = $echelle;

        return $this;
    }

    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(string $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getAdpersonnel(): ?string
    {
        return $this->adpersonnel;
    }

    public function setAdpersonnel(string $adpersonnel): self
    {
        $this->adpersonnel = $adpersonnel;

        return $this;
    }

    public function getAdvacance(): ?string
    {
        return $this->advacance;
    }

    public function setAdvacance(string $advacance): self
    {
        $this->advacance = $advacance;

        return $this;
    }

    public function getTelephonne(): ?string
    {
        return $this->telephonne;
    }

    public function setTelephonne(string $telephonne): self
    {
        $this->telephonne = $telephonne;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Absence[]
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences[] = $absence;
            $absence->setPersonnel($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            if ($absence->getPersonnel() === $this) {
                $absence->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttestationSalaire[]
     */
    public function getAttestations_salaire(): Collection
    {
        return $this->attestations_salaire;
    }

    public function addAttestations_salaire(AttestationSalaire $attestation_salaire): self
    {
        if (!$this->attestations_salaire->contains($attestation_salaire)) {
            $this->attestations_salaire[] = $attestation_salaire;
            $attestation_salaire->setPersonnel($this);
        }

        return $this;
    }

    public function removeAttestations_salaire(AttestationSalaire $attestation_salaire): self
    {
        if ($this->attestations_salaire->removeElement($attestation_salaire)) {
            if ($attestation_salaire->getPersonnel() === $this) {
                $attestation_salaire->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttestationTravail[]
     */
    public function getAttestations_travail(): Collection
    {
        return $this->attestations_travail;
    }

    public function addAttestations_travail(AttestationTravail $attestation_travail): self
    {
        if (!$this->attestations_travail->contains($attestation_travail)) {
            $this->attestations_travail[] = $attestation_travail;
            $attestation_travail->setPersonnel($this);
        }

        return $this;
    }

    public function removeAttestations_travail(AttestationTravail $attestation_travail): self
    {
        if ($this->attestations_travail->removeElement($attestation_travail)) {
            if ($attestation_travail->getPersonnel() === $this) {
                $attestation_travail->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrdreMission[]
     */
    public function getOrdres(): Collection
    {
        return $this->ordres;
    }

    public function addOrdre(OrdreMission $ordre): self
    {
        if (!$this->ordres->contains($ordre)) {
            $this->ordres[] = $ordre;
            $ordre->setPersonnel($this);
        }

        return $this;
    }

    public function removeOrdre(OrdreMission $ordre): self
    {
        if ($this->ordres->removeElement($ordre)) {
            if ($ordre->getPersonnel() === $this) {
                $ordre->setPersonnel(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     * @return Personnel
     */
    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     * @return Personnel
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getSexeType(): string
    {
        return self::SEXE[$this->sexe];
    }

    public function getSexeArType(): string
    {
        return self::SEXEAR[$this->sexe_ar];
    }

    public function getEtatCivilType(): string
    {
        return self::ETATCIVIL[$this->etatcivil];
    }

    public function getSituationFamilaireArType(): string
    {
        return self::SITUATIONFAMILIAIREAR[$this->situation_familiale_ar];
    }
}