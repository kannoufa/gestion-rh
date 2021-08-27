<?php

namespace App\Entity;

use App\Entity\Personnel;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\FicheRenseignementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FicheRenseignementRepository::class)
 */
class FicheRenseignement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Personnel::class, inversedBy="fiche")
     */
    private $personnel;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]{7}$/",
     *     message="le P.P.R doit contenir 7 chiffres"
     * )
     */
    private $doti;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datenaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieunaiss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nbrenfant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fonction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $echelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $daterecrut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $diplome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adpersonnel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adelectronique;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoti(): ?int
    {
        return $this->doti;
    }

    public function setDoti(int $doti): self
    {
        $this->doti = $doti;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getDatenaiss(): ?\DateTime
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTime $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

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

    public function getDaterecrut(): ?\DateTime
    {
        return $this->daterecrut;
    }

    public function setDaterecrut(\DateTime $daterecrut): self
    {
        $this->daterecrut = $daterecrut;

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

    public function getAdelectronique(): ?string
    {
        return $this->adelectronique;
    }

    public function setAdelectronique(string $adelectronique): self
    {
        $this->adelectronique = $adelectronique;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

}