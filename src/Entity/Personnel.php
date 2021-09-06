<?php

namespace App\Entity;

use App\Entity\Absence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PersonnelRepository::class)
 * @UniqueEntity(
 *     fields={"ppr"},
 *     message="Ce numéro P.P.R existe déjà"
 * )
 */
class Personnel
{
    const SEXEAR = [
        0 => 'أنثى',
        1 => 'ذكر',
    ];

    const SITUATIONFAMILIAIREAR = [
        0 => 'أعزب',
        1 => 'متزوج',
        2 => 'مطلق',
        3 => 'أرمل',
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
     * @ORM\OneToOne(targetEntity=EnregistrementEntree::class, mappedBy="personnel")
     */
    private $entree;

    /**
     * @ORM\OneToOne(targetEntity=FicheRenseignement::class, mappedBy="personnel")
     */
    private $fiche;

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
    private $nationalite_ar;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $echellon;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_effet_echelon;

    /**
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="string", length=50)
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

    public function __construct()
    {
        $this->absences = new ArrayCollection();
        $this->attestations_salaire = new ArrayCollection();
        $this->attestations_travail = new ArrayCollection();
        $this->ordres = new ArrayCollection();
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

    public function getAncienneteEchelon(): ?string
    {
        return $this->anciennete_echelon;
    }

    public function setAncienneteEchelon(?string $anciennete_echelon): self
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

    public function getAncienneteGrade(): ?string
    {
        return $this->anciennete_grade;
    }

    public function setAncienneteGrade(?string $anciennete_grade): self
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

    public function getAncienneteAdministrative(): ?string
    {
        return $this->anciennete_administrative;
    }

    public function setAncienneteAdministrative(?string $anciennete_administrative): self
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
    public function getAttestationsSalaire(): Collection
    {
        return $this->attestations_salaire;
    }

    public function addAttestationsSalaire(AttestationSalaire $attestation_salaire): self
    {
        if (!$this->attestations_salaire->contains($attestation_salaire)) {
            $this->attestations_salaire[] = $attestation_salaire;
            $attestation_salaire->setPersonnel($this);
        }

        return $this;
    }

    public function removeAttestationsSalaire(AttestationSalaire $attestation_salaire): self
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
    public function getAttestationsTravail(): Collection
    {
        return $this->attestations_travail;
    }

    public function addAttestationsTravail(AttestationTravail $attestation_travail): self
    {
        if (!$this->attestations_travail->contains($attestation_travail)) {
            $this->attestations_travail[] = $attestation_travail;
            $attestation_travail->setPersonnel($this);
        }

        return $this;
    }

    public function removeAttestationsTravail(AttestationTravail $attestation_travail): self
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
}