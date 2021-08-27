<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idDemande;

    /**
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeDemande;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRecu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDemande(): ?int
    {
        return $this->idDemande;
    }

    public function setIdDemande(int $idDemande): self
    {
        $this->idDemande = $idDemande;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getTypeDemande(): ?string
    {
        return $this->typeDemande;
    }

    public function setTypeDemande(string $typeDemande): self
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    public function getDateRecu(): ?\DateTime
    {
        return $this->dateRecu;
    }

    public function setDateRecu(\DateTime $dateRecu): self
    {
        $this->dateRecu = $dateRecu;

        return $this;
    }
}