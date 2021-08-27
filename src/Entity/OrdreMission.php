<?php

namespace App\Entity;

use App\Repository\OrdreMissionRepository;
use App\Entity\Personnel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdreMissionRepository::class)
 */
class OrdreMission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Personnel::class, inversedBy="ordres")
     */
    private $personnel;

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
    private $objet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transport;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chauffeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $membres;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_depart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heure_dep;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_retour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heure_retour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $frais;

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

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getChauffeur(): ?string
    {
        return $this->chauffeur;
    }

    public function setChauffeur(string $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    public function getMembres(): ?string
    {
        return $this->membres;
    }

    public function setMembres(string $membres): self
    {
        $this->membres = $membres;

        return $this;
    }

    public function getDateDepart(): ?\DateTime
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTime $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getHeureDep(): ?string
    {
        return $this->heure_dep;
    }

    public function setHeureDep(string $heure_dep): self
    {
        $this->heure_dep = $heure_dep;

        return $this;
    }

    public function getDateRetour(): ?\DateTime
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTime $date_retour): self
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getHeureRetour(): ?string
    {
        return $this->heure_retour;
    }

    public function setHeureRetour(string $heure_retour): self
    {
        $this->heure_retour = $heure_retour;

        return $this;
    }

    public function getFrais(): ?string
    {
        return $this->frais;
    }

    public function setFrais(string $frais): self
    {
        $this->frais = $frais;

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