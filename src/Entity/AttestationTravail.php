<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Personnel;
use App\Repository\AttestationTravailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttestationTravailRepository::class)
 */
class AttestationTravail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Personnel::class, inversedBy="attestations_travail")
     */
    private $personnel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_fr;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex(
     *     pattern="/^[0-9]{7}$/",
     *     message="le P.P.R doit contenir 7 chiffres"
     * )
     */
    private $ppr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_fr;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cni;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

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

    public function getNomFr(): ?string
    {
        return $this->nom_fr;
    }

    public function setNomFr(string $nom_fr): self
    {
        $this->nom_fr = $nom_fr;

        return $this;
    }

    public function getPpr(): ?string
    {
        return $this->ppr;
    }

    public function setPpr(string $ppr): self
    {
        $this->ppr = $ppr;

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

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

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