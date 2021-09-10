<?php

namespace App\Entity;

use App\Repository\DepartementServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartementServiceRepository::class)
 */
class DepartementService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomFr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomAr;

    /**
     * @ORM\OneToMany(targetEntity=Personnel::class, mappedBy="departementService")
     */
    private $personnel;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $chef;

    public function __construct()
    {
        $this->personnel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFr(): ?string
    {
        return $this->nomFr;
    }

    public function setNomFr(string $nomFr): self
    {
        $this->nomFr = $nomFr;

        return $this;
    }

    public function getNomAr(): ?string
    {
        return $this->nomAr;
    }

    public function setNomAr(string $nomAr): self
    {
        $this->nomAr = $nomAr;

        return $this;
    }

    /**
     * @return Collection|Personnel[]
     */
    public function getPersonnels(): Collection
    {
        return $this->personnel;
    }

    public function addPersonnel(Personnel $personnel): self
    {
        if (!$this->personnel->contains($personnel)) {
            $this->personnel[] = $personnel;
            $personnel->setDepartementService($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): self
    {
        if ($this->personnel->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getDepartementService() === $this) {
                $personnel->setDepartementService(null);
            }
        }

        return $this;
    }

    public function getChef(): ?User
    {
        return $this->chef;
    }

    public function setChef(?User $chef): self
    {
        $this->chef = $chef;

        return $this;
    }
}