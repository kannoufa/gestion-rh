<?php

namespace App\Entity;

use App\Repository\EnregistrementEntreeRepository;
use App\Entity\Personnel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnregistrementEntreeRepository::class)
 */
class EnregistrementEntree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
        
    /**
     * @ORM\OneToOne(targetEntity=Personnel::class, inversedBy="entree")
     */
    private $personnel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_fr;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_naissance_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situation_familiale_ar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_fonction;

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

    public function getNomAr(): ?string
    {
        return $this->nom_ar;
    }

    public function setNomAr(string $nom_ar): self
    {
        $this->nom_ar = $nom_ar;

        return $this;
    }

    public function getPrenomAr(): ?string
    {
        return $this->prenom_ar;
    }

    public function setPrenomAr(string $prenom_ar): self
    {
        $this->prenom_ar = $prenom_ar;

        return $this;
    }

    public function getNomFr(): ?string
    {
        return $this->nom_fr;
    }

    public function setNomFr(string $nom_fr): self
    {
        $this->nom_fr = $nom_fr;

        return $this;
    }

    public function getPrenomFr(): ?string
    {
        return $this->prenom_fr;
    }

    public function setPrenomFr(string $prenom_fr): self
    {
        $this->prenom_fr = $prenom_fr;

        return $this;
    }

    public function getDateNaissanceAr(): ?\DateTime
    {
        return $this->date_naissance_ar;
    }

    public function setDateNaissanceAr(\DateTime $date_naissance_ar): self
    {
        $this->date_naissance_ar = $date_naissance_ar;

        return $this;
    }

    public function getLieuNaissanceAr(): ?string
    {
        return $this->lieu_naissance_ar;
    }

    public function setLieuNaissanceAr(string $lieu_naissance_ar): self
    {
        $this->lieu_naissance_ar = $lieu_naissance_ar;

        return $this;
    }

    public function getNationaliteAr(): ?string
    {
        return $this->nationalite_ar;
    }

    public function setNationaliteAr(string $nationalite_ar): self
    {
        $this->nationalite_ar = $nationalite_ar;

        return $this;
    }

    public function getSituationFamilialeAr(): ?string
    {
        return $this->situation_familiale_ar;
    }

    public function setSituationFamilialeAr(string $situation_familiale_ar): self
    {
        $this->situation_familiale_ar = $situation_familiale_ar;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateFonction(): ?\DateTime
    {
        return $this->date_fonction;
    }

    public function setDateFonction(\DateTime $date_fonction): self
    {
        $this->date_fonction = $date_fonction;

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